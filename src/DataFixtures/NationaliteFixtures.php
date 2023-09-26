<?php

namespace App\DataFixtures;

use App\Entity\Nationalite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationaliteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 5) as $i) {
            $category = new Nationalite();
            $category->setNationalite('Nationalite' . $i);
            $manager->persist($category);
            $this->addReference('nationalite_' . $i, $category); // "expose" l'objet à l'extérieur de la classe pour les liaisons avec Movie }
        }

        $manager->flush();
    }
}
