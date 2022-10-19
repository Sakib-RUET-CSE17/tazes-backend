<?php

namespace App\EntityListener;

use App\Entity\BookLend;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Psr\Container\ContainerInterface;

class BookLendEntityListener
{

    public function __construct(
        private ContainerInterface $parameterBag,
    ) {
    }

    public function prePersist(BookLend $bookLend, LifecycleEventArgs $event)
    {
        $bookLend->setDateOfLend(new \DateTime);
    }

    // public function preUpdate(User $user, PreUpdateEventArgs $event)
    // {
    //     // $changes = $event->getEntityChangeSet();
    //     $plainPassword = $user->getPlainPassword();
    //     if ($plainPassword) {
    //         $user->setPassword($this->userPasswordHasher->hashPassword(
    //             $user,
    //             $plainPassword
    //         ));
    //     }
    // }
}
