<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    
    public function __construct( UserPasswordHasherInterface $hash)
    {
        $this->hash = $hash;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("test@test.fr");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->hash->hashPassword($user, "Password"));

        $manager->persist($user);
        $manager->flush();
    }
}
