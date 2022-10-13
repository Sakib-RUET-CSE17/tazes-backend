<?php

namespace App\EntityListener;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Psr\Container\ContainerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// use App\Security\EmailVerifier;
// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Bridge\Twig\Mime\TemplatedEmail;
// use Symfony\Component\Mime\Address;
// use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class UserEntityListener
{

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private ContainerInterface $parameterBag,
        // private MailerInterface $mailer,
        // private EmailVerifier $emailVerifier,
        // private VerifyEmailHelperInterface $verifyEmailHelper,
    ) {
    }

    public function prePersist(User $user, LifecycleEventArgs $event)
    {
        $user->setPassword($this->userPasswordHasher->hashPassword(
            $user,
            $user->getPlainPassword()
        ));

        $enableEmailVerification = $this->parameterBag->get('enableEmailVerification');

        if (strtolower($enableEmailVerification) === 'false') {
            $user->setIsVerified(true);
        }
    }

    // public function postPersist(User $user, LifecycleEventArgs $event)
    // {
    //     $enableEmailVerification = $this->parameterBag->get('enableEmailVerification');

    //     if (strtolower($enableEmailVerification) === 'true') {
    //         $signatureComponents = $this->verifyEmailHelper->generateSignature(
    //             'app_verify_email',
    //             $user->getId(),
    //             $user->getEmail(),
    //             [
    //                 'id' => $user->getId()
    //             ]
    //         );

    //         $senderEmail = $this->parameterBag->get('senderEmail');
    //         $senderName = $this->parameterBag->get('senderName');

    //         $email = new TemplatedEmail();
    //         $email->from(new Address($senderEmail, $senderName));
    //         $email->to($user->getEmail());
    //         $email->subject('Please Confirm your Email');
    //         $email->htmlTemplate('security/confirmation_email.html.twig');
    //         $email->context(['signedUrl' => $signatureComponents->getSignedUrl()]);

    //         $this->mailer->send($email);
    //     }
    // }

    public function preUpdate(User $user, PreUpdateEventArgs $event)
    {
        $changes = $event->getEntityChangeSet();
        if (isset($changes['password']) && $changes['password']) {
            $user->setPassword($this->userPasswordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            ));
        }
    }
}
