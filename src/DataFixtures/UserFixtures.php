<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface as PasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        protected UserPasswordHasherInterface $passwordHasherInterface
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 6) as $i) {
            $user = new User();
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setPassword($this->passwordHasherInterface->hashPassword(
                $user,
                'password'
            ));
            $user->setRoles(['ROLE_USER']);
            if ($i == 1) {
                $user->setRoles(['ROLE_ADMIN']);
            }
            $user->setFirstName('FirstName' . $i);
            $user->setLastName('LastName' . $i);
            $manager->persist($user);
            $this->addReference('user_' . $i, $user); // "expose" l'objet à l'extérieur de la classe pour les liaisons avec Movie }
        }

        //create an admin user
        $manager->flush();
    }
}
