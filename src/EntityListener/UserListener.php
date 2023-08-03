<?php

namespace App\EntityListener;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    #[ORM\PrePersist]
    public function prePersist(User $user, LifecycleEventArgs $args)
    {
        if ($user->getCreatedAt() === null)
            $user->setCreatedAt(new DateTimeImmutable());
        $user->setUpdatedAt(new DateTimeImmutable());
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $user->getPassword()));
    }

    #[ORM\PreUpdate]
    public function preUpdate(User $user, PreUpdateEventArgs $args)
    {
        //dd($args);
        if ($user->getCreatedAt() === null)
            $user->setCreatedAt(new DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $user->getPassword()));
    }

    #[ORM\PostPersist]
    public function postPersist(User $user, LifecycleEventArgs $args)
    {

    }

    #[ORM\PostUpdate]
    public function postUpdate(User $user, LifecycleEventArgs $args)
    {

    }
}