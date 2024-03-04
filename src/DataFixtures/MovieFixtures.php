<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Xylis\FakerCinema\Provider\Movie as MovieProvider;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new MovieProvider($faker));

        foreach (range(1, 40) as $i) {
            $movie = (new Movie())
                ->setTitle($faker->unique()->movie)
                ->setDescription($faker->text(200))
                ->setOnline((bool)rand(0, 1))
                ->setDuration(rand(60, 180))
                ->setReleaseDate($faker->dateTimeBetween(
                    "-30 years",
                ))
                ->setCategory($this->getReference('category_' . rand(1, 5)))
                ->setMedia($this->getReference('mediaObject_movie_' . $i));
            //Ajoute entre 2 et 6 acteurs dans le film, tous différents en se basant sur les fixtures
            $actors = [];
            foreach (range(1, rand(2, 6)) as $j) {
                $actor = $this->getReference('actor_' . rand(1, 10));
                if (!in_array($actor, $actors)) {
                    $actors[] = $actor;
                    $movie->addActor($actor);
                }
            }

            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ActorFixtures::class,

        ];
    }
}
