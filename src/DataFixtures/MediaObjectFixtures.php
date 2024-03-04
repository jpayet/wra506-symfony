<?php

namespace App\DataFixtures;

use App\Entity\MediaObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaObjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //MediaObject for movies
        foreach (range(1, 40) as $i) {
            copy(
                __DIR__ . '/../../public/assets/fixtures/movies/movie' . rand(1, 8) . '.jpg',
                __DIR__ . '/../../public/assets/fixtures/movies/movie' . $i . 'copy.jpg'
            );
            $file = new UploadedFile(
                __DIR__ . '/../../public/assets/fixtures/movies/movie' . $i . 'copy.jpg',
                'movie' . $i . '.jpg',
                'image/jpeg',
                null,
                true
            );
            $mediaObject = (new MediaObject())
                ->setFile(new UploadedFile($file, 'movie' . $i . '.jpg', 'image/jpeg', null, true))
                ->setFilePath($file->getPathname());

            $manager->persist($mediaObject);
            $this->addReference('mediaObject_movie_' . $i, $mediaObject);
        }
        $manager->flush();
    }
}