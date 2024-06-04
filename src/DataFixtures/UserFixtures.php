<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $rawUsers = [   ['alice@gmail.com', 'abcdef'],
                        ['bob@gmail.com', 'abcdef'],
                        ['jane@gmail.com', 'abcdef'],
                        ['jack@gmail.com', 'abcdef'],];

        foreach ($rawUsers as $rawUser)
        {
            $user = new User();
            $user->setEmail($rawUser[0]);
            $user->setRoles(['ROLE_USER']);
            $user->setApiToken(md5(uniqid().rand(1000000, 9999999)));
            $hashedPassword = $this->userPasswordHasherInterface->hashPassword($user, $rawUser[1]);
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $manager->flush();
        }
    }
}
