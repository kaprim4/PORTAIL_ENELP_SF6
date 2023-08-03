<?php

namespace App\Controller;

use App\Entity\Hook;
use App\Repository\HookRepository;
use App\Repository\ModuleRepository;
use App\Repository\ParameterRepository;
use App\Repository\PriceRepository;
use App\Repository\RoleRepository;
use App\Repository\WidgetRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @throws ReflectionException|TransportExceptionInterface
     * @throws Exception
     */
    #[Route('/', name: 'app_home')]
    public function index(HookRepository $hookRepository, WidgetRepository $widgetRepository, ManagerRegistry $registry, PriceRepository $priceRepository, ParameterRepository $parameterRepository): Response
    {
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if (!$current_user) {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $moduleRepo = new ModuleRepository($registry);

        $header_widgets = $widgetRepository->findByHook($hookRepository->findOneBy(['alias' => 'HEADER']));

        $home_widgets = [];
        foreach ($widgetRepository->findByHook($hookRepository->findOneBy(['alias' => 'HOME_PAGE'])) as $w) {
            $elm = [
                'libelle' => $w->getLibelle(),
                'alias' => $w->getAlias(),
                'hook' => $w->getHook(),
                'mode' => $w->getMode(),
                'iconColor' => $w->getIconColor(),
                'bgColor' => $w->getBgColor(),
                'textColor' => $w->getTextColor(),
                'isActivated' => $w->isIsActivated()
            ];

            $elm["module"] = "";
            $elm["moduleName"] = "";
            $elm["icon"] = "";
            $elm["classRepoName"] = "";
            $elm["elements"] = "";
            $elm["elementsCount"] = "";
            $elm["elementsEnableCount"] = "";
            $elm["elementsDisableCount"] = "";
            $elm["elementsRate"] = "";

            if ($w->getModule() != "") {
                if ($w->getMode() == 'ed') {
                    $classRepoName = 'App\Repository\\' . ucfirst($w->getModule()->getNameInDb()) . 'Repository';
                    $ref = new ReflectionClass($classRepoName);
                    $classRepoObject = $ref->newInstanceArgs([$registry]);
                    $elements = $classRepoObject->findAll();
                    $elements_enable = $classRepoObject->findBy(['isActivated' => true]);
                    $elements_disable = $classRepoObject->findBy(['isActivated' => false]);
                    $elm["module"] = $w->getModule()->getLibelle();
                    $elm["moduleName"] = $w->getModule()->getNameInDb();
                    $elm["icon"] = $w->getModule()->getIcon();
                    $elm["classRepoName"] = $classRepoName;
                    $elm["elements"] = $elements;
                    $elm["elementsCount"] = count($elements);
                    $elm["elementsEnableCount"] = count($elements_enable);
                    $elm["elementsDisableCount"] = count($elements_disable);
                    $rate = count($elements) > 0 ? floatval((count($elements_enable) / (count($elements_enable) + count($elements_disable))) * 100) : 0;
                    $elm["elementsRate"] = number_format($rate, 2);

                } elseif ($w->getMode() == 'listing') {

                    $classRepoName = 'App\Repository\\' . ucfirst($w->getModule()->getNameInDb()) . 'Repository';
                    $ref = new ReflectionClass($classRepoName);
                    $classRepoObject = $ref->newInstanceArgs([$registry]);

                    $className = 'App\Entity\\' . ucfirst($w->getModule()->getNameInDb());
                    $ref = new ReflectionClass($className);
                    $classObject = $ref->newInstanceArgs();

                    $elements = $classRepoObject->findBy(['isActivated' => true], null, 5);

                    $form = $this->createForm('App\Form\\' . ucfirst($w->getModule()->getNameInDb()) . 'Type', $classObject);
                    $fieldNames = ['#'];
                    $attributes = ['id'];
                    foreach ($form->all() as $column) {
                        if ($column->getName() != "password") {
                            $fieldNames[] = $column->getConfig()->getOptions()['label'];
                            $attributes[] = $column->getName();
                        }
                    }

                    $elm["module"] = $w->getModule()->getLibelle();
                    $elm["moduleName"] = $w->getModule()->getNameInDb();
                    $elm["icon"] = $w->getModule()->getIcon();
                    $elm["classRepoName"] = $classRepoName;
                    $elm["fieldNames"] = $fieldNames;
                    $elm["attributes"] = $attributes;
                    $elm["elements"] = $elements;

                } elseif ($w->getMode() == 'shortcut') {
                    $elm["module"] = $w->getModule()->getLibelle();
                    $elm["moduleName"] = $w->getModule()->getNameInDb();
                    $elm["icon"] = $w->getModule()->getIcon();
                }
            }
            $home_widgets[] = $elm;
        }

        $recent_activities = [];
        $parameter = $parameterRepository->findOneByAlias(['alias' => 'DAY_LIMIT_FOR_LISTING']);
        $prices = $priceRepository->getPriceGreaterThan($parameter->getValue(), null);

        $limit = intval($parameterRepository->findOneByAlias(['alias' => 'RECENT_ACTIVITIES_LIMIT'])->getValue());
        $i = 0;
        foreach ($prices as $price) {
            if ($i < $limit) {
                $elm = [];
                $elm["status"] = $price->getPriceStatus();
                $elm["gasStation"] = $price->getGasStation();
                $elm["priceRows"] = $price->getPriceRows();
                $elm["appliedAt"] = $price->getAppliedAt();
                $recent_activities[] = $elm;
                $i++;
            }
        }

        return $this->render('home/index.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Tableau de bord',
            'module_mod_menu' => $moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $header_widgets,
            'home_widgets' => $home_widgets,
            'recent_activities' => $recent_activities,
        ]);
    }
}
