<?php

namespace App\EventSubscribers;

use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Security\Http\Firewall\LogoutListener;

class LogoutSubscriber implements EventSubscriberInterface
{
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
    private $security;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserRepository $userRepository
     * @param SessionRepository $sessionRepository
     */
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator, UserRepository $userRepository, SessionRepository $sessionRepository, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->sessionRepository = $sessionRepository;
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        $user = $this->security->getUser();
        if($user){
            $session = $this->sessionRepository->findOneBy([
                'user' => $user,
                'isActivated' => 1,
                'isDeleted' => 0,
            ], orderBy: [
                'id' => 'DESC'
            ]);
            $session->setUpdatedAt(new DateTimeImmutable());
            $session->setIsActivated(0);
            $session->setIsDeleted(1);
            $this->sessionRepository->save($session, true);
        }

        // get the security token of the session that is about to be logged out
        $token = $event->getToken();

        // get the current request
        $request = $event->getRequest();

        // get the current response, if it is already set by another listener
        $response = $event->getResponse();

        // configure a custom logout response to the homepage
        $response = new RedirectResponse(
            $this->urlGenerator->generate('app_home'),
            Response::HTTP_SEE_OTHER
        );
        $event->setResponse($response);
    }
}