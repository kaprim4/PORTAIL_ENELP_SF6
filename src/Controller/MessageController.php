<?php

namespace App\Controller;

use App\Config\ConfigFunc;
use App\Entity\Message;
use App\Kernel;
use App\Repository\HookRepository;
use App\Repository\ModuleRepository;
use App\Repository\ParameterRepository;
use App\Repository\MessageRepository;
use App\Repository\PriceRepository;
use App\Repository\RoleRepository;
use App\Repository\SessionRepository;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use App\Repository\WidgetRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/message')]
class MessageController extends AbstractController
{
    private MessageRepository $messageRepository;
    private ParameterRepository $parameterRepository;
    private HookRepository $hookRepository;
    private WidgetRepository $widgetRepository;
    private ModuleRepository $moduleRepo;
    private int $limit_for_list;
    private array $header_widgets;

    /**
     * @param ModuleRepository $moduleRepo
     * @param MessageRepository $messageRepository
     * @param ParameterRepository $parameterRepository
     * @param HookRepository $hookRepository
     * @param WidgetRepository $widgetRepository
     */
    public function __construct(ModuleRepository $moduleRepo, MessageRepository $messageRepository, ParameterRepository $parameterRepository, HookRepository $hookRepository, WidgetRepository $widgetRepository)
    {
        $this->moduleRepo = $moduleRepo;
        $this->messageRepository = $messageRepository;
        $this->parameterRepository = $parameterRepository;
        $this->hookRepository = $hookRepository;
        $this->widgetRepository = $widgetRepository;
        $this->header_widgets = $this->widgetRepository->findByHook($this->hookRepository->findOneBy(['alias' => 'HEADER']));
        $this->limit_for_list = intval($this->parameterRepository->findOneByAlias(['alias' => 'DAY_LIMIT_FOR_LISTING'])->getValue());
    }

    /**
     * @throws Exception
     */
    #[Route('/', name: 'app_message_index', methods: ['GET'])]
    public function index(TopicRepository $topicRepository, PriceRepository $priceRepository, Kernel $kernel, SessionRepository $sessionRepository, UserRepository $userRepository, RoleRepository $roleRepository): Response
    {
        if ($this->container->has('security.token_storage')) {
            $current_user = $this->getUser();
            if (!$current_user) {
                return $this->redirectToRoute('app_login');
            }
        } else {
            return $this->redirectToRoute('app_login');
        }

        $message_count = intval($this->messageRepository->getMessagesCount($current_user));

        $projectDir = $kernel->getProjectDir();
        $filename = "$projectDir/public/build/assets/json/mail-list.json";

        $mails = [];
        $mail_list["primary"] = [];
        $mail_list["social"] = [];
        $mail_list["promotions"] = [];
        foreach ($this->messageRepository->findBy(['receiver' => $current_user], orderBy: ['createdAt' => 'DESC']) as $message) {
            $tab = [
                "id" => $message->getId(),
                "starred" => $message->isIsStarred(),
                "readed" => $message->isIsReaded(),
                "deleted" => $message->isIsDeleted(),
                "name" => 'Portail WINXO',
                "title" => $message->getSubject(),
                "html_text" => $message->getBody(),
                "plain_text" => strip_tags($message->getBody()),
                "date" => $message->getCreatedAt()->format("d M Y"),
                "userImg" => "/images/logo-sm.png",
                "labeltype" => $message->getLabelType()->getNameInDb(),
            ];

            if ($message->isIsDeleted())
                $tab["tabtype"] = "trash";
            elseif ($message->isIsStarred())
                $tab["tabtype"] = "important";
            else
                $tab["tabtype"] = "inbox";

            $mail_list["primary"][] = $tab;
        }
        $mails[] = $mail_list;
        $serializer = $this->container->get('serializer');
        $results = $serializer->serialize($mails, 'json');
        $fs = new Filesystem();
        $fs->dumpFile($filename, $results);

        $labelTypes = [];
        foreach ($this->messageRepository->findAll() as $message) {
            $labelTypes[] = [
                'label' => $message->getLabelType()->getNameInDb(),
                'title' => $message->getLabelType()->getLibelle(),
                'color' => $message->getLabelType()->getWidgets()[0]->getBgColor(),
            ];
        }

        $chat_list = [];

        $sessions = $sessionRepository->findBy([
            'isDeleted' => 0,
        ]);
        if ($current_user->getRole()->getAlias() != "ROLE_STATION") {
            foreach ($sessions as $session) {
                $user = $session->getUser();
                if ($user->getRole()->getAlias() == "ROLE_STATION") {
                    $chat_list[] = $user;
                }
            }
        } else {
            $criteria = new Criteria();
            $criteria->where(Criteria::expr()->neq('alias', "ROLE_STATION"));
            $roles = $roleRepository->matching($criteria)->getValues();
            foreach ($roles as $role) {
                $users = $userRepository->findBy([
                    'role' => $role,
                ]);
                foreach ($users as $user) {
                    $chat_list[] = $user;
                }
            }
        }

        return $this->render('message/index.html.twig', [
            'root_uri' => 'Accueil',
            'title' => 'Messagerie',
            'module_mod_menu' => $this->moduleRepo->findByParam("isModule"),
            'dictionnary_mod_menu' => $this->moduleRepo->findByParam("isDictionnary"),
            'parameter_mod_menu' => $this->moduleRepo->findByParam("isParameter"),
            'user' => $current_user,
            'limit_for_list' => $this->limit_for_list,
            'user_role' => $current_user->getRole(),
            'header_widgets' => $this->header_widgets,
            'message_count' => $message_count,
            'messages' => $this->messageRepository->findAll(),
            'chat_list' => $chat_list,
            'labelTypes' => array_unique($labelTypes, SORT_REGULAR),
            'topics' => $topicRepository->findAll(),
        ]);
    }

    #[Route('/{id}/readed/{value}', name: 'app_message_readed', methods: ['GET'])]
    public function readed(Request $request, MessageRepository $messageRepository): Response
    {
        $value = intval($request->get('value'));
        $message = $messageRepository->find($request->get('id'));
        $message->setIsReaded($value == 1);
        $message->setUpdatedAt(new DateTimeImmutable());
        $messageRepository->save($message, true);
        $api_rep = [
            "id" => $request->get('id'),
            "subject" => $message->getSubject(),
            "sender" => ($message->getSender()->getRole()->getAlias() == 'ROLE_STATION' ? $message->getSender()->getGasStation()->getLibelle() : $message->getSender()->getFirstName() . ' ' . $message->getSender()->getLastName()),
            "receiver" => ($message->getReceiver()->getRole()->getAlias() == 'ROLE_STATION' ? $message->getReceiver()->getGasStation()->getLibelle() : $message->getReceiver()->getFirstName() . ' ' . $message->getReceiver()->getLastName()),
            "isReaded" => $message->isIsReaded(),
            "isStarred" => $message->isIsStarred(),
        ];
        $serializer = $this->container->get('serializer');
        $results = $serializer->serialize($api_rep, 'json');
        return new Response($results, Response::HTTP_OK, (array)Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/starred/{value}', name: 'app_message_starred', methods: ['GET'])]
    public function starred(Request $request, MessageRepository $messageRepository): Response
    {
        $value = intval($request->get('value'));
        $message = $messageRepository->find($request->get('id'));
        $message->setIsStarred($value == 1);
        $message->setUpdatedAt(new DateTimeImmutable());
        $messageRepository->save($message, true);
        $api_rep = [
            "id" => $request->get('id'),
            "subject" => $message->getSubject(),
            "sender" => ($message->getSender()->getRole()->getAlias() == 'ROLE_STATION' ? $message->getSender()->getGasStation()->getLibelle() : $message->getSender()->getFirstName() . ' ' . $message->getSender()->getLastName()),
            "receiver" => ($message->getReceiver()->getRole()->getAlias() == 'ROLE_STATION' ? $message->getReceiver()->getGasStation()->getLibelle() : $message->getReceiver()->getFirstName() . ' ' . $message->getReceiver()->getLastName()),
            "isReaded" => $message->isIsReaded(),
            "isStarred" => $message->isIsStarred(),
        ];
        $serializer = $this->container->get('serializer');
        $results = $serializer->serialize($api_rep, 'json');
        return new Response($results, Response::HTTP_OK, (array)Response::HTTP_SEE_OTHER);
    }
}