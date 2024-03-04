<?php

namespace App\DataFixtures;

use App\Entity\Nationalite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationaliteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nationalites = ['Allemand', 'Français', 'Italien', 'Espagnol', 'Anglais', 'Américain', 'Canadien', 'Mexicain', 'Argentin', 'Brésilien'];
        foreach (range(1, 10) as $i) {
            $category = new Nationalite();
            $category->setNationalite($nationalites[$i - 1]);
            $manager->persist($category);
            $this->addReference('nationalite_' . $i, $category); // "expose" l'objet à l'extérieur de la classe pour les liaisons avec Movie }
        }

        $manager->flush();
    }
}
