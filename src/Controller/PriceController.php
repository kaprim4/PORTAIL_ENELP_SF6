<?php

namespace App\Controller;

use App\Config\ConfigFunc;
use App\Entity\Message;
use App\Entity\Price;
use App\Entity\PriceRow;
use App\Entity\PriceStatistic;
use App\Entity\Topic;
use App\Form\PriceType;
use App\Repository\ActualPriceRepository;
use App\Repository\HookRepository;
use App\Repository\MessageRepository;
use App\Repository\ModuleRepository;
use App\Repository\ParameterRepository;
use App\Repository\PriceRepository;
use App\Repository\PriceRowRepository;
use App\Repository\PriceStatisticRepository;
use App\Repository\PriceStatusRepository;
use App\Repository\RoleRepository;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use App\Repository\WholesalePriceDetailRepository;
use App\Repository\WidgetRepository;
use DateTimeImmutable;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/price')]
class PriceController extends AbstractController
{
    private PriceRepository $priceRepository;
    private ParameterRepository $parameterRepository;
    private HookRepository $hookRepository;
    private WidgetRepository $widgetRepository;
    private ModuleRepository $moduleRepo;
    private Topic $topic;

    private int $limit_for_add;
    private int $limit_for_cancel;
    private int $limit_for_list;
    private array $header_widgets;

    /**
     * @param ModuleRepository $moduleRepo
     * @param PriceRepository $priceRepository
     * @param ParameterRepository $parameterRepository
     * @param HookRepository $hookRepository
     * @param WidgetRepository $widgetRepository
     * @throws NonUniqueResultException
     */
    public function __construct(ModuleRepository $moduleRepo, PriceRepository $priceRepository, ParameterRepository $parameterRepository, HookRepository $hookRepository, WidgetRepository $widgetRepository, TopicRepository $topicRepository)
    {
        $this->moduleRepo = $moduleRepo;
        $this->priceRepository = $priceRepository;
        $this->parameterRepository = $parameterRepository;
        $this->hookRepository = $hookRepository;
        $this->widgetRepository = $widgetRepository;
        $this->header_widgets = $this->widgetRepository->findByHook($this->hookRepository->findOneBy(['alias' => 'HEADER']));
        $this->limit_for_list = intval($this->parameterRepository->findOneByAlias(['alias' => 'DAY_LIMIT_FOR_LISTING'])->getValue());
        $this->limit_for_add = intval($this->parameterRepository->findOneByAlias(['alias' => 'ADD_COUNT_PER_DAY'])->getValue());
        $this->limit_for_cancel = intval($this->parameterRepository->findOneByAlias(['alias' => 'ORDER_CANCEL_DELAY'])->getValue());
        $this->topic = $topicRepository->findOneByModule(['module' => $this->moduleRepo->findOneByNameInDb(['nameInDb' => 'price'])]);
    }

    /**
     * @throws Exception
     */
    #[Route('/', name: 'app_price_index', methods: ['GET'])]
    public function index(ActualPriceRepository $actualPriceRepository, WholesalePriceDetailRepository $wholesalePriceDetailRepository, ModuleRepository $moduleRepository, MessageRepository $messageRepository, MailerInterface $mailer, UserRepository $userRepository, RoleRepository $roleRepository): Response
    {
        $grades = null;
        $actual_prices = [];
        $wholesale_prices = [];
        $gas_station = null;
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if ($current_user) {
                if ($current_user->getRole()->getAlias() == 'ROLE_STATION') {
                    $grades = $current_user->getGasStation()->getGradeList();
                    foreach ($grades as $grade) {
                        $actual_prices[] = $actualPriceRepository->getActualPricesByGrade(
                            $current_user->getGasStation(), $grade
                        );
                        $wholesale_prices[] = $wholesalePriceDetailRepository->getWholesalePricesByGrade(
                            $current_user->getGasStation(), $grade
                        );
                    }
                    $gas_station = $current_user->getGasStation();
                }
            } else {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $super_admin_user = $userRepository->findOneBy([
            'role' => $roleRepository->findOneBy([
                'alias' => "ROLE_SUPER_ADMIN",
            ]),
        ]);

        $admin_users = $userRepository->findBy([
            'role' => $roleRepository->findOneBy([
                'alias' => "ROLE_ADMIN",
            ]),
        ]);

        $price_mails = $this->priceRepository->findBy([
            'gasStation' => $current_user->getGasStation(),
            'isMailSent' => false,
        ], orderBy: [
            'createdAt' => 'ASC'
        ]);

        foreach ($price_mails as $price_mail) {
            $mail_template = $this->render('message/price.template.html.twig', [
                'price' => $price_mail,
                'admin_fullname' => $super_admin_user->getFirstName() . ' ' . $super_admin_user->getLastName(),
            ]);

            $message = new Message();
            $message->setTopic($this->topic);
            $message->setSender($super_admin_user);
            $message->setReceiver($this->getUser());
            $message->setPriority(5);
            $message->setSubject('APAG ► ' . $current_user->getGasStation()->getLibelle() . ' : Nouveau prix saisi');
            $message->setBody($mail_template->getContent());
            $message->setIsReaded(false);
            $message->setIsStarred(false);
            $message->setCreatedAt(new DateTimeImmutable($price_mail->getAppliedAt()->format("Y-m-d H:i")));
            $message->setLabelType($this->moduleRepo->findOneByNameInDb('price'));
            $messageRepository->save($message, true);

            $email = (new Email())
                ->from(new Address('noreply@winxo.com', '֍ PORTAIL WINXO'))
                ->to(new Address($super_admin_user->getEmail(), $super_admin_user->getFirstName() . ' ' . $super_admin_user->getLastName()))
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                ->priority(Email::PRIORITY_HIGH)
                ->subject($message->getSubject())
                ->html($mail_template->getContent());

            foreach ($admin_users as $admin_user) {
                $email->cc(new Address($admin_user->getEmail(), $admin_user->getFirstName() . ' ' . $admin_user->getLastName()));
            }

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                throw new Exception($e->getMessage());
            }

            $price_mail->setIsMailSent(true);
            $this->priceRepository->save($price_mail, true);
        }

        return $this->render('price/index.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'gasStation' => $gas_station,
            'limit_for_list' => $this->limit_for_list,
            'limit_for_add' => $this->limit_for_add,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'prices' => $this->priceRepository->getPriceGreaterThan($this->limit_for_list, $current_user),
            'grades' => $grades,
            'wholesale_prices' => $wholesale_prices,
            'actual_prices' => $actual_prices,
            'nextCycle' => ConfigFunc::nextCycle($this->parameterRepository),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/new', name: 'app_price_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PriceRowRepository $priceRowRepository, PriceStatusRepository $priceStatusRepository, PriceStatisticRepository $priceStatisticRepository, ActualPriceRepository $actualPriceRepository, WholesalePriceDetailRepository $wholesalePriceDetailRepository): Response
    {
        $grades = [];
        $actual_prices = [];
        $wholesale_prices = [];
        $gas_station = null;
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if ($current_user) {
                if ($current_user->getRole()->getAlias() != 'ROLE_STATION') {
                    return $this->redirectToRoute('app_price_index');
                } else {
                    $grades = $current_user->getGasStation()->getGradeList();
                    foreach ($grades as $grade) {
                        $actual_prices[] = $actualPriceRepository->getActualPricesByGrade(
                            $current_user->getGasStation(), $grade
                        );
                        $wholesale_prices[] = $wholesalePriceDetailRepository->getWholesalePricesByGrade(
                            $current_user->getGasStation(), $grade
                        );
                    }
                    $gas_station = $current_user->getGasStation();
                }
            } else {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $price_count = intval($this->priceRepository->getPricesCount($current_user->getGasStation()));
        $price = new Price();
        $form = $this->createFormBuilder($price)->getForm();

        if ($request->get('price_form') && $request->get('price_form') == 'price_add') {

            if ($price_count == $this->limit_for_add) {
                $this->addFlash('danger', 'Vous avez droit à ' . $this->limit_for_add . ' changements de prix par jour.');
                return $this->redirectToRoute('app_price_new');
            } else {

                $proposalAppDateTime = date("Y-m-d H:i", strtotime($request->get('proposalAppDate') . ' ' . $request->get('proposalAppTime')));
                $nextCycle = date("Y-m-d H:i", strtotime(ConfigFunc::nextCycle($this->parameterRepository)));
                if ($proposalAppDateTime >= $nextCycle) {

                    $price->setGasStation($current_user->getGasStation());
                    $price->setPriceStatus($priceStatusRepository->findOneBy(['id' => 0]));
                    $price->setAppliedAt(new DateTimeImmutable($request->get('proposalAppDate') . ' ' . $request->get('proposalAppTime')));
                    $price->setIsActivated(true);
                    $price->setIsDeleted(false);
                    $price->setIsMailSent(false);

                    $priceStatistic = new PriceStatistic();
                    $priceStatistic->setSource('Web');
                    $ua = ConfigFunc::getBrowser();
                    $web_platform = $ua['name'] . "|" . $ua['version'] . "|" . $ua['platform'];
                    $priceStatistic->setWebPlateform($web_platform);
                    $priceStatisticRepository->save($priceStatistic, true);

                    $price->setPriceStatistics($priceStatistic);
                    $this->priceRepository->save($price, true);

                    foreach ($grades as $grade) {
                        if ($request->get('grade_' . $grade->getId()) != '') {
                            $priceRow = new PriceRow();
                            $priceRow->setGrade($grade);
                            $priceRow->setNewValue($request->get('grade_' . $grade->getId()));
                            $priceRow->setOldValue($request->get('old_grade_' . $grade->getId()));
                            $priceRow->setPrice($price);
                            $priceRowRepository->save($priceRow, true);
                        }
                    }

                    $this->addFlash('success', 'Vous avez saisi un prix prévu pour ' . date("d/m/Y", strtotime($request->get('proposalAppDate'))) . ' à ' . $request->get('proposalAppTime') . '. Vous pouvez consulter votre historique de proposition sur le panel "Historique"');
                    return $this->redirectToRoute('app_price_index', [], Response::HTTP_SEE_OTHER);
                } else {
                    $this->addFlash('danger', 'Vous ne pouvez pas saisir un prix dans une période antérieure du créneau permi par le système.');
                    return $this->redirectToRoute('app_price_new');
                }
            }
        }

        return $this->render('price/new.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'gasStation' => $gas_station,
            'limit_for_list' => $this->limit_for_list,
            'limit_for_add' => $this->limit_for_add,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'grades' => $grades,
            'wholesale_prices' => $wholesale_prices,
            'actual_prices' => $actual_prices,
            'nextCycle' => ConfigFunc::nextCycle($this->parameterRepository),
            'price_count' => $price_count,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_price_show', methods: ['GET'])]
    public function show(Price $price, ActualPriceRepository $actualPriceRepository, WholesalePriceDetailRepository $wholesalePriceDetailRepository): Response
    {
        $grades = null;
        $actual_prices = [];
        $wholesale_prices = [];
        $gas_station = null;
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if ($current_user) {
                if ($current_user->getRole()->getAlias() == 'ROLE_STATION') {
                    $gas_station = $current_user->getGasStation();
                    $grades = $current_user->getGasStation()->getGradeList();
                    foreach ($grades as $grade) {
                        $actual_prices[] = $actualPriceRepository->getActualPricesByGrade(
                            $current_user->getGasStation(), $grade
                        );
                        $wholesale_prices[] = $wholesalePriceDetailRepository->getWholesalePricesByGrade(
                            $current_user->getGasStation(), $grade
                        );
                    }
                } else {
                    $gas_station = $price->getGasStation();
                }
            } else {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('price/show.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'gasStation' => $gas_station,
            'limit_for_list' => $this->limit_for_list,
            'limit_for_add' => $this->limit_for_add,
            'limit_for_cancel' => $this->limit_for_cancel,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'price' => $price,
            'grades' => $grades,
            'wholesale_prices' => $wholesale_prices,
            'actual_prices' => $actual_prices,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}/edit', name: 'app_price_edit', methods: ['GET', 'POST'])]
    public function edit(Price $price, Request $request, PriceRowRepository $priceRowRepository, PriceStatusRepository $priceStatusRepository, PriceStatisticRepository $priceStatisticRepository, ActualPriceRepository $actualPriceRepository, WholesalePriceDetailRepository $wholesalePriceDetailRepository): Response
    {
        $grades = [];
        $actual_prices = [];
        $wholesale_prices = [];
        $gas_station = null;
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if ($current_user) {
                if ($current_user->getRole()->getAlias() == 'ROLE_STATION') {
                    $gas_station = $current_user->getGasStation();
                } else {
                    $gas_station = $price->getGasStation();
                }
                $grades = $gas_station->getGradeList();
                foreach ($grades as $grade) {
                    $actual_prices[] = $actualPriceRepository->getActualPricesByGrade($gas_station, $grade);
                    $wholesale_prices[] = $wholesalePriceDetailRepository->getWholesalePricesByGrade($gas_station, $grade);
                }

            } else {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $price_count = intval($this->priceRepository->getPricesCount($current_user->getGasStation()));
        $form = $this->createFormBuilder($price)->getForm();

        if ($request->get('price_form') && $request->get('price_form') == 'price_edit') {
            $proposalAppDate = $request->get('proposalAppDate');
            $proposalAppTime = $request->get('proposalAppTime');
            $price->setAppliedAt(new DateTimeImmutable($proposalAppDate . ' ' . $proposalAppTime));
            $price->setUpdatedAt(new DateTimeImmutable());

            $this->priceRepository->save($price, true);

            foreach ($price->getPriceRows() as $priceRow) {
                if ($request->get('grade_' . $priceRow->getGrade()->getId()) != '') {
                    $priceRow->setNewValue($request->get('grade_' . $priceRow->getGrade()->getId()));
                    $priceRow->setPrice($price);
                    $priceRowRepository->save($priceRow, true);
                }
            }
            $this->addFlash('success', 'Le prix prévu pour ' . date("d/m/Y", strtotime($request->get('proposalAppDate'))) . ' à ' . $request->get('proposalAppTime') . ' a été modifié avec succès');
            return $this->redirectToRoute('app_price_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('price/edit.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'gasStation' => $gas_station,
            'limit_for_list' => $this->limit_for_list,
            'limit_for_add' => $this->limit_for_add,
            'limit_for_cancel' => $this->limit_for_cancel,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'grades' => $grades,
            'wholesale_prices' => $wholesale_prices,
            'actual_prices' => $actual_prices,
            'nextCycle' => ConfigFunc::nextCycle($this->parameterRepository),
            'price_count' => $price_count,
            'form' => $form,
            'price' => $price,
            'button_label' => 'Mettre à jour',
        ]);
    }

    #[Route('/{id}', name: 'app_price_delete', methods: ['POST'])]
    public function delete(Request $request, Price $price, PriceRepository $priceRepository, PriceRowRepository $priceRowRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $price->getId(), $request->request->get('_token'))) {
            $priceRows = $price->getPriceRows();
            foreach ($priceRows as $priceRow) {
                $priceRowRepository->remove($priceRow, true);
            }
            //$priceStatisticRepository->remove($price->getPriceStatistics(), true);
            $priceRepository->remove($price, true);
        }
        return $this->redirectToRoute('app_price_index', [], Response::HTTP_SEE_OTHER);
    }
}
