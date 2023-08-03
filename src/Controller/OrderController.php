<?php

namespace App\Controller;

use App\Config\ConfigFunc;
use App\Entity\Message;
use App\Entity\Order;
use App\Entity\OrderRow;
use App\Entity\OrderHistory;
use App\Entity\Topic;
use App\Form\OrderType;
use App\Repository\ActualPriceRepository;
use App\Repository\HolidayRepository;
use App\Repository\HookRepository;
use App\Repository\MessageRepository;
use App\Repository\ModuleRepository;
use App\Repository\OrderHistoryRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderRowRepository;
use App\Repository\OrderStatusRepository;
use App\Repository\ParameterRepository;
use App\Repository\ProductRepository;
use App\Repository\RoleRepository;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use App\Repository\WholesalePriceDetailRepository;
use App\Repository\WidgetRepository;
use DateTime;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    private OrderRepository $orderRepository;
    private ParameterRepository $parameterRepository;
    private HookRepository $hookRepository;
    private WidgetRepository $widgetRepository;
    private ModuleRepository $moduleRepo;
    private Topic $topic;

    private int $limit_for_add;
    private int $limit_for_cancel;
    private int $limit_for_car_min;
    private int $limit_for_car_max;
    private string $order_car_unit;
    private array $param_day_suspend_from;
    private array $param_day_suspend_to;
    private int $limit_for_list;
    private array $header_widgets;

    /**
     * @param ModuleRepository $moduleRepo
     * @param OrderRepository $orderRepository
     * @param ParameterRepository $parameterRepository
     * @param HookRepository $hookRepository
     * @param WidgetRepository $widgetRepository
     */
    public function __construct(ModuleRepository $moduleRepo, OrderRepository $orderRepository, ParameterRepository $parameterRepository, HookRepository $hookRepository, WidgetRepository $widgetRepository, TopicRepository $topicRepository)
    {
        $this->moduleRepo = $moduleRepo;
        $this->orderRepository = $orderRepository;
        $this->parameterRepository = $parameterRepository;
        $this->hookRepository = $hookRepository;
        $this->widgetRepository = $widgetRepository;
        $this->header_widgets = $this->widgetRepository->findByHook($this->hookRepository->findOneBy(['alias' => 'HEADER']));
        $this->limit_for_list = intval($this->parameterRepository->findOneByAlias(['alias' => 'DAY_LIMIT_FOR_LISTING'])->getValue());
        $this->limit_for_add = intval($this->parameterRepository->findOneByAlias(['alias' => 'ORDER_ADD_COUNT_PER_DAY'])->getValue());
        $this->limit_for_cancel = intval($this->parameterRepository->findOneByAlias(['alias' => 'ORDER_CANCEL_DELAY'])->getValue());
        $this->order_car_unit = $this->parameterRepository->findOneByAlias(['alias' => 'ORDER_CAR_UNIT'])->getValue();
        $this->limit_for_car_min = intval($this->parameterRepository->findOneByAlias(['alias' => 'ORDER_CAR_MIN'])->getValue());
        $this->limit_for_car_max = intval($this->parameterRepository->findOneByAlias(['alias' => 'ORDER_CAR_MAX'])->getValue());
        $this->param_day_suspend_from = explode('-', $this->parameterRepository->findOneByAlias(['alias' => 'ORDER_SUSPEND_DAY_FROM'])->getValue());
        $this->param_day_suspend_to = explode('-', $this->parameterRepository->findOneByAlias(['alias' => 'ORDER_SUSPEND_DAY_TO'])->getValue());
        $this->topic = $topicRepository->findOneByModule(['module' => $this->moduleRepo->findOneByNameInDb(['nameInDb' => 'order'])]);
    }


    /**
     * @throws Exception
     */
    #[Route('/', name: 'app_order_index', methods: ['GET'])]
    public function index(ActualPriceRepository $actualPriceRepository, WholesalePriceDetailRepository $wholesalePriceDetailRepository, MessageRepository $messageRepository, MailerInterface $mailer, UserRepository $userRepository, RoleRepository $roleRepository): Response
    {
        $grades = null;
        $actual_prices = [];
        $wholesale_prices = [];
        $orders = null;
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
                    $orders = $this->orderRepository->getOrdersByGasStation($current_user->getGasStation());
                    $gas_station = $current_user->getGasStation();
                }else{
                    $orders = $this->orderRepository->findAll();
                }
            } else {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $countCreatedOrders = 0;
        $countPlanedOrders = 0;
        $countLoadedOrders = 0;
        $countPartialOrders = 0;
        $countShippedOrders = 0;
        foreach ($orders as $order) {
            foreach ($order->getOrderRows() as $orderRow) {
                $numItems = count($orderRow->getOrderHistories());
                $i = 0;
                foreach ($orderRow->getOrderHistories() as $orderHistory) {
                    if (++$i === $numItems) {
                        if ($orderHistory->getOrderStatus()->getId() == 0)
                            $countCreatedOrders++;
                        if ($orderHistory->getOrderStatus()->getId() == 2)
                            $countPlanedOrders++;
                        if ($orderHistory->getOrderStatus()->getId() == 3 && $orderHistory->getQty() == 0)
                            $countLoadedOrders++;
                        if ($orderHistory->getOrderStatus()->getId() == 8)
                            $countPartialOrders++;
                        if ($orderHistory->getOrderStatus()->getId() == 4)
                            $countShippedOrders++;
                        break;
                    }
                }
                if (count($order->getOrderRows()) > 1)
                    break;
            }
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

        $order_mails = $this->orderRepository->findBy([
            'gasStation' => $current_user->getGasStation(),
            'isMailSent' => false,
        ], orderBy: [
            'createdAt' => 'ASC'
        ]);
        foreach ($order_mails as $order_mail) {
            $mail_template = $this->render('message/order.template.html.twig', [
                'order' => $order_mail,
                'admin_fullname' => $super_admin_user->getFirstName() . ' ' . $super_admin_user->getLastName(),
            ]);

            $message = new Message();
            $message->setTopic($this->topic);
            $message->setSender($super_admin_user);
            $message->setReceiver($this->getUser());
            $message->setPriority(5);
            $message->setSubject('COMMANDES ► ' . $current_user->getGasStation()->getLibelle() . ' : Nouvelle commande saisie');
            $message->setBody($mail_template->getContent());
            $message->setIsReaded(false);
            $message->setIsStarred(false);
            $message->setCreatedAt(new DateTimeImmutable($order_mail->getCreatedAt()->format("Y-m-d H:i")));
            $message->setLabelType($this->moduleRepo->findOneByNameInDb('order'));
            $messageRepository->save($message, true);

            $email = (new Email())
                ->from(new Address('noreply@winxo.com', '֍ PORTAIL WINXO'))
                ->to(new Address($super_admin_user->getEmail(), $super_admin_user->getFirstName() . ' ' . $super_admin_user->getLastName()))
                //->cc('cc@example.com')
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

            $order_mail->setIsMailSent(true);
            $this->orderRepository->save($order_mail, true);
        }

        return $this->render('order/index.html.twig', [
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
            'orders' => $orders,
            'grades' => $grades,
            'wholesale_prices' => $wholesale_prices,
            'actual_prices' => $actual_prices,
            'countCreatedOrders' => $countCreatedOrders,
            'countPlanedOrders' => $countPlanedOrders,
            'countLoadedOrders' => $countLoadedOrders,
            'countPartialOrders' => $countPartialOrders,
            'countShippedOrders' => $countShippedOrders,
            'nextCycle' => ConfigFunc::nextCycle($this->parameterRepository),
        ]);
    }


    /**
     * @throws Exception
     */
    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrderRowRepository $orderRowRepository, OrderStatusRepository $orderStatusRepository, OrderHistoryRepository $orderStatisticRepository, HolidayRepository $holidayRepository, ProductRepository $productRepository, OrderHistoryRepository $orderHistoryRepository): Response
    {
        $grades = [];
        $gas_station = null;
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if ($current_user) {
                if ($current_user->getRole()->getAlias() != 'ROLE_STATION') {
                    return $this->redirectToRoute('app_order_index');
                } else {
                    $grades = $current_user->getGasStation()->getGradeList();
                    $gas_station = $current_user->getGasStation();
                }
            } else {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $orders = $this->orderRepository->getOrderGreaterThan($this->limit_for_list, $current_user);
        $order_count = $this->orderRepository->getOrdersCount($current_user->getGasStation());

        //$current_day =  date("05-11-2022 09:05:00");
        $current_day = date("d-m-Y H:i:s");
        $time_now = date("H:i:s", strtotime($current_day));
        $date_now = date("Y-m-d", strtotime($current_day));

        /* get params from current date */
        $weekDay = date('w', strtotime($current_day));
        $time_suspend_db_from = date("H:i:s", strtotime($this->param_day_suspend_from[1]));
        $time_suspend_db_to = date("H:i:s", strtotime($this->param_day_suspend_to[1]));
        $dateNextMonday = date('Y-m-d', strtotime('next monday'));
        $desired_delivery_date = date("Y-m-d", strtotime($current_day . "+2 day"));

        $time_now_dt = new DateTime($date_now . " " . $time_now);
        $time_suspend_db_from_dt = new DateTime($date_now . " " . $time_suspend_db_from);
        $time_suspend_db_to_dt = new DateTime($date_now . " " . $time_suspend_db_to);

        $diff_from = ConfigFunc::dateIntervalToSec($time_suspend_db_from_dt, $time_now_dt);
        $diff_to = ConfigFunc::dateIntervalToSec($time_suspend_db_to_dt, $time_now_dt);

        $enable_filling = 1;
        if ($weekDay == 0) {
            $enable_filling = 0;
            if ($diff_to > 0)
                $desired_delivery_date = date("Y-m-d", strtotime($current_day . "+2 days"));
            else
                $desired_delivery_date = date("Y-m-d", strtotime($dateNextMonday . "+2 days"));
        } elseif ($weekDay == ConfigFunc::getDayWeekNumber($this->param_day_suspend_from[0])) {
            $enable_filling = 0;
            if ($diff_from > 0)
                $desired_delivery_date = date("Y-m-d", strtotime($current_day . "+2 days"));
            else
                $desired_delivery_date = date("Y-m-d", strtotime($dateNextMonday . "+2 days"));
        } elseif ($weekDay == ConfigFunc::getDayWeekNumber($this->param_day_suspend_to[0])) {
            $enable_filling = 0;
            if ($diff_to > 0)
                $desired_delivery_date = date("Y-m-d", strtotime($dateNextMonday . "+2 days"));
            else
                $desired_delivery_date = date("Y-m-d", strtotime($current_day . "+2 days"));
        }

        /* jours fériés */
        $holiday_data = $holidayRepository->findBy([
            'month' => date("m", strtotime($desired_delivery_date)),
            'day' => date("d", strtotime($desired_delivery_date)),
        ]);
        if (count($holiday_data) > 0)
            $desired_delivery_date = date("Y-m-d", strtotime($desired_delivery_date . "+1 day"));

        /* plusieurs cmds */
        $order_not_shipped = 0;
        foreach ($this->orderRepository->findAll() as $_order) {
            foreach ($_order->getOrderRows() as $orderRow) {
                $numItems = count($orderRow->getOrderHistories());
                $i = 0;
                foreach ($orderRow->getOrderHistories() as $orderHistory) {
                    if(++$i === $numItems) {
                        if (!in_array($orderHistory->getOrderStatus()->getId(), [4, 8]) && $orderHistory->getAppliedAt()->format("Y-m-d") != $desired_delivery_date) {
                            $order_not_shipped++;
                            break;
                        }
                    }
                }
                if (count($_order->getOrderRows()) > 1)
                    break;
            }
        }
        if ($order_not_shipped > 0)
            $desired_delivery_date = date("Y-m-d", strtotime($desired_delivery_date . "+" . $order_not_shipped . " day"));

        //dd($order_not_shipped);

        $order_count_added_per_date = $this->orderRepository->getOrdersCountAddedPerDate($current_user->getGasStation(), $desired_delivery_date);

        $order = new Order();
        $form = $this->createFormBuilder($order)->getForm();
        if ($request->get('action_form') && $request->get('action_form') == 'order_add') {

            if ($order_count_added_per_date == $this->limit_for_add) {
                $this->addFlash('danger', 'Vous avez droit à ' . $this->limit_for_add . ' commande(s) par jour.');
                return $this->redirectToRoute('app_order_new');
            } else {
                $max_order_id = explode('CC', $this->orderRepository->getMaxOrderId()[0]['sellDocWeb']);
                $data_post = $request->get('order_detail');
                $nb_row = count($data_post);
                $date_add_od = date("Y-m-d H:i:s");

                $order->setGasStation($current_user->getGasStation());
                $order->setUser($current_user);
                $order->setSellDocWeb(ConfigFunc::formatOrderRef(intval($max_order_id[1]) + 1));
                $order->setSellDocDate(new DateTimeImmutable($date_add_od));
                $order->setIsExported(0);
                $order->setIsActivated(1);
                $order->setIsDeleted(1);
                $this->orderRepository->save($order, true);

                if (count($data_post) > 0) {
                    $relatedOrderRows = $orderRowRepository->findBy(['order' => $order]);

                    foreach ($relatedOrderRows as $orderRow)
                        $orderRowRepository->remove($orderRow, true);

                    for ($i = 0; $i < $nb_row; $i++) {
                        if ($data_post[$i]['qty'] != 0) {
                            $product = $productRepository->findOneBy(['id' => $data_post[$i]['id_product']]);
                            $orderStatus = $orderStatusRepository->findOneBy(['id' => 0]);
                            $orderRow = new OrderRow();
                            $orderRow->setOrder($order);
                            $orderRow->setProduct($product);
                            $orderRow->setIsPartial(0);
                            $orderRowRepository->save($orderRow, true);

                            $orderHistory = new OrderHistory();
                            $orderHistory->setOrderRow($orderRow);
                            $orderHistory->setQty($data_post[$i]['qty']);
                            $orderHistory->setAppliedAt(new DateTimeImmutable($request->get('desired_delivery_date')));
                            $orderHistory->setOrderStatus($orderStatus);
                            $orderHistoryRepository->save($orderHistory, true);
                        }
                    }
                    $this->addFlash('success', 'Vous avez saisi une commande prévu pour ' . date("d/m/Y", strtotime($request->get('desired_delivery_date'))) . '. Vous pouvez consulter votre historique de commande sur le panel "Historique"');
                    return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
                } else {

                    $this->addFlash('danger', "Une erreur s'est produite lors de la saisie de la commannde.");
                    return $this->redirectToRoute('app_order_new');
                }
            }
        }

        return $this->render('order/new.html.twig', [
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
            'order_car_unit' => $this->order_car_unit,
            'limit_for_car_min' => $this->limit_for_car_min,
            'limit_for_car_max' => $this->limit_for_car_max,
            'param_day_suspend_from' => ConfigFunc::frenchDayByNumber(ConfigFunc::getDayWeekNumber($this->param_day_suspend_from[0])),
            'param_time_suspend_from' => date("H:i", strtotime($this->param_day_suspend_from[1])),
            'param_day_suspend_to' => ConfigFunc::frenchDayByNumber(ConfigFunc::getDayWeekNumber($this->param_day_suspend_to[0])),
            'param_time_suspend_to' => date("H:i", strtotime($this->param_day_suspend_to[1])),
            'desired_delivery_date' => $desired_delivery_date,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'order_count' => $order_count,
            'orders' => $orders,
            'grades' => $grades,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        $gas_station = null;
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if ($current_user) {
                if ($current_user->getRole()->getAlias() == 'ROLE_STATION') {
                    $gas_station = $current_user->getGasStation();
                } else {
                    $gas_station = $order->getGasStation();
                }
            } else {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('order/show.html.twig', [
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
            'order' => $order,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Order $order, Request $request, OrderRowRepository $orderRowRepository, OrderStatusRepository $orderStatusRepository, OrderHistoryRepository $orderHistoryRepository, HolidayRepository $holidayRepository, ProductRepository $productRepository): Response
    {
        $gas_station = null;
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if ($current_user) {
                if ($current_user->getRole()->getAlias() == 'ROLE_STATION') {
                    $gas_station = $current_user->getGasStation();
                } else {
                    $gas_station = $order->getGasStation();
                }
            } else {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $order_count = $this->orderRepository->getOrdersCount($gas_station);
        $current_day = date("d-m-Y H:i:s");
        $time_now = date("H:i:s", strtotime($current_day));
        $date_now = date("Y-m-d", strtotime($current_day));

        /* get params from current date */
        $weekDay = date('w', strtotime($current_day));
        $time_suspend_db_from = date("H:i:s", strtotime($this->param_day_suspend_from[1]));
        $time_suspend_db_to = date("H:i:s", strtotime($this->param_day_suspend_to[1]));
        $dateNextMonday = date('Y-m-d', strtotime('next monday'));
        $desired_delivery_date = date("Y-m-d", strtotime($current_day . "+2 day"));

        $time_now_dt = new DateTime($date_now . " " . $time_now);
        $time_suspend_db_from_dt = new DateTime($date_now . " " . $time_suspend_db_from);
        $time_suspend_db_to_dt = new DateTime($date_now . " " . $time_suspend_db_to);

        $diff_from = ConfigFunc::dateIntervalToSec($time_suspend_db_from_dt, $time_now_dt);
        $diff_to = ConfigFunc::dateIntervalToSec($time_suspend_db_to_dt, $time_now_dt);

        $enable_filling = 1;
        if ($weekDay == 0) {
            $enable_filling = 0;
            if ($diff_to > 0)
                $desired_delivery_date = date("Y-m-d", strtotime($current_day . "+2 days"));
            else
                $desired_delivery_date = date("Y-m-d", strtotime($dateNextMonday . "+2 days"));
        } elseif ($weekDay == ConfigFunc::getDayWeekNumber($this->param_day_suspend_from[0])) {
            $enable_filling = 0;
            if ($diff_from > 0)
                $desired_delivery_date = date("Y-m-d", strtotime($current_day . "+2 days"));
            else
                $desired_delivery_date = date("Y-m-d", strtotime($dateNextMonday . "+2 days"));
        } elseif ($weekDay == ConfigFunc::getDayWeekNumber($this->param_day_suspend_to[0])) {
            $enable_filling = 0;
            if ($diff_to > 0)
                $desired_delivery_date = date("Y-m-d", strtotime($dateNextMonday . "+2 days"));
            else
                $desired_delivery_date = date("Y-m-d", strtotime($current_day . "+2 days"));
        }

        /* jours fériés */
        $holiday_data = $holidayRepository->findBy([
            'month' => date("m", strtotime($desired_delivery_date)),
            'day' => date("d", strtotime($desired_delivery_date)),
        ]);
        if (count($holiday_data) > 0)
            $desired_delivery_date = date("Y-m-d", strtotime($desired_delivery_date . "+1 day"));

        /* plusieurs cmds */
        $order_shipped_data = 0;
        foreach ($this->orderRepository->findAll() as $_order) {
            foreach ($_order->getOrderRows() as $orderRow) {
                foreach ($orderRow->getOrderHistories() as $orderHistory) {
                    if ($orderHistory->getOrderStatus()->getId() == 0 && $orderHistory->getAppliedAt() == $desired_delivery_date)
                        $order_shipped_data++;
                }
            }
        }
        if ($order_shipped_data > 0)
            $desired_delivery_date = date("Y-m-d", strtotime($desired_delivery_date . "+" . $order_shipped_data . " day"));

        $form = $this->createFormBuilder($order)->getForm();

        if ($request->get('action_form') && $request->get('action_form') == 'order_edit') {

            //dd($request);

            $data_post = $request->get('order_detail');
            $desired_delivery_date = $request->get('desired_delivery_date');
            $nb_row = count($data_post);
            $order->setUpdatedAt(new DateTimeImmutable());
            $this->orderRepository->save($order, true);

            if (count($data_post) > 0) {
                for ($i = 0; $i < $nb_row; $i++) {
                    if ($data_post[$i]['qty'] != 0) {

                        $product = $productRepository->findOneBy(['id' => $data_post[$i]['id_product']]);
                        foreach ($order->getOrderRows() as $orderRow){
                            if($orderRow->getProduct() === $product){
                                foreach ($orderRow->getOrderHistories() as $orderHistory){
                                    if($orderHistory->getOrderRow()->getProduct() === $product){
                                        $orderHistory->setQty($data_post[$i]['qty']);
                                        $orderHistory->setAppliedAt(new DateTimeImmutable($desired_delivery_date));
                                        $orderHistoryRepository->save($orderHistory, true);
                                    }
                                }
                            }
                        }
                    }
                }
                $this->addFlash('success', 'Vous avez saisi une commande prévu pour ' . date("d/m/Y", strtotime($request->get('desired_delivery_date'))) . '. Vous pouvez consulter votre historique de commande sur le panel "Historique"');
                return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);

            } else {

                $this->addFlash('danger', "Une erreur s'est produite lors de la saisie de la commannde.");
                return $this->redirectToRoute('app_order_new');
            }
        }

        return $this->render('order/edit.html.twig', [
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
            'order_car_unit' => $this->order_car_unit,
            'limit_for_car_min' => $this->limit_for_car_min,
            'limit_for_car_max' => $this->limit_for_car_max,
            'param_day_suspend_from' => ConfigFunc::frenchDayByNumber(ConfigFunc::getDayWeekNumber($this->param_day_suspend_from[0])),
            'param_time_suspend_from' => date("H:i", strtotime($this->param_day_suspend_from[1])),
            'param_day_suspend_to' => ConfigFunc::frenchDayByNumber(ConfigFunc::getDayWeekNumber($this->param_day_suspend_to[0])),
            'param_time_suspend_to' => date("H:i", strtotime($this->param_day_suspend_to[1])),
            'desired_delivery_date' => $desired_delivery_date,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'order_count' => $order_count,
            'form' => $form,
            'order' => $order,
            'button_label' => 'Mettre à jour',
        ]);
    }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, OrderRepository $orderRepository, OrderRowRepository $orderRowRepository, OrderHistoryRepository $orderHistoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
            $orderRows = $order->getOrderRows();
            foreach ($orderRows as $orderRow) {
                foreach ($orderRow->getOrderHistories() as $orderHistory) {
                    $orderHistoryRepository->remove($orderHistory, true);
                }
                $orderRowRepository->remove($orderRow, true);
            }
            $orderRepository->remove($order, true);
            $this->addFlash('success', 'La commande a été supprimée avec succès.');
        }
        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
