<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\RoleTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // System Admin
        $systemAdmin = new User();
        $systemAdmin->setEmail('admin@mcm-starter.com');
        $systemAdmin->setPlainPassword('aaaaaa');
        $systemAdmin->setIsVerified(true);
        // Password: admin_pass
        $systemAdmin->setType(RoleTypeEnum::Admin);
        // $systemAdmin->setName('System Admin');
        $manager->persist($systemAdmin);

        // create 20 general user
        for ($i = 1; $i <= 20; $i++) {
            // user
            $user = new User();
            $user->setEmail('user' . strval($i) . '@mcm-starter.com');
            $user->setPlainPassword('aaaaaa');
            $user->setIsVerified(true);
            $user->setType(RoleTypeEnum::User);
            // $user->setName('User' . strval($i));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
