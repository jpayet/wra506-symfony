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
        $firstNames = ['Jean', 'Paul', 'Jacques', 'Pierre', 'Marie', 'Louise', 'Julie', 'Julien', 'Juliette', 'Julia', 'Sebastien', 'Lucie', 'Antoine', 'Isabelle', 'François', 'Sophie', 'Nicolas', 'Hélène', 'Victor', 'Catherine', 'Alexandre', 'Émilie', 'Louis', 'Charlotte'];
        $lastNames = ['Martin', 'Bernard', 'Thomas', 'Dubois', 'Moreau', 'Simon', 'Laurent', 'Lefevre', 'Leroy', 'Roux', 'Garcia', 'Lopez', 'Fournier', 'Perez', 'Girard', 'Dufour', 'Colin', 'Caron', 'Fontaine', 'Rousseau', 'Vincent', 'Leclerc', 'Lemoine', 'Clement'];

        foreach (range(1, 15) as $i) {
            $actor = new Actor();
            $actor->setFirstName($firstNames[rand(0, 23)]);
            $actor->setLastName($lastNames[rand(0, 23)]);
            $actor->setNationalite($this->getReference('nationalite_' . rand(1, 10)));
            $actor->setDateOfBirthday(new \DateTime('-' . rand(18, 80) . ' years'));
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
