<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $firstNames = ['Jean', 'Paul', 'Jacques', 'Pierre', 'Marie', 'Anne', 'Julie', 'Jeanne', 'Pierrette', 'Jacqueline'];
        $lastNames = ['Dupont', 'Durand', 'Duchemin', 'Duchesse', 'Duc', 'Ducroc', 'Ducrocq', 'Ducroq', 'Ducro', 'Ducros'];

        foreach (range(1, 10) as $i) {
            $actor = new Actor();
            $actor->setFirstName($firstNames[rand(0, 9)]);
            $actor->setLastName($lastNames[rand(0, 9)]);
            $actor->setNationalite($this->getReference('nationalite_' . rand(1, 5)));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            NationaliteFixtures::class,
        ];
    }
}
