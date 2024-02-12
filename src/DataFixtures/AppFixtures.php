<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = $this->createAdmin();

        $manager->persist($admin);

        $manager->flush();
    }

    public function createAdmin(): User
    {
        $admin = new User();

        $passwordHashed = $this->hasher->hashPassword($admin, "azerty1234A*");

        $admin->setFirstName("gégé");
        $admin->setLastName("Tulipe");
        $admin->setEmail("gege@gmail.com");
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $admin->setAddress("123 Rue du Pape");
        $admin->setPassword($passwordHashed);
        $admin->setCreatedAt(new DateTimeImmutable());
        $admin->setUpdatedAt(new DateTimeImmutable());

        return $admin;
    }
}
