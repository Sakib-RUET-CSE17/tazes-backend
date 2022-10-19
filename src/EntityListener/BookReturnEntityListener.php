<?php

namespace App\EntityListener;

use App\Entity\BookReturn;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Psr\Container\ContainerInterface;

class BookReturnEntityListener
{

    public function __construct(
        private ContainerInterface $parameterBag,
    ) {
    }

    public function prePersist(BookReturn $bookReturn, LifecycleEventArgs $event)
    {
        $returnedBooks = $bookReturn->getBooks();
        
        foreach ($returnedBooks as $returnedBook) {
            $returnedBook->getBookLend()->removeBook($returnedBook);
        }

        $bookReturn->setDateOfReturn(new \DateTime);
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
