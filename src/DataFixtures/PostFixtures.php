<?php

namespace App\DataFixtures;

use App\Entity\Posts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public const IMAGES = [
        'adios.jpg',
        'floppa.jpeg',
        'IMG_7325.JPG',
        'kaori-peace-sign.jpg.webp',
    ];
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        copy(__DIR__ . '/adios.jpg', __DIR__ . '/../../public/uploads/posts/adios.jpg');
        copy(__DIR__ . '/floppa.jpeg', __DIR__ . '/../../public/uploads/posts/floppa.jpeg');
        copy(__DIR__ . '/IMG_7325.JPG', __DIR__ . '/../../public/uploads/posts/IMG_7325.JPG');
        copy(__DIR__ . '/kaori-peace-sign.jpg.webp', __DIR__ . '/../../public/uploads/posts/kaori-peace-sign.jpg.webp');
        for($i = 0; $i < UserFixtures::USERS; $i++) {
            $post = new Posts();
            $post->setUser($this->getReference('user_' . $i));
            $post->setPicturePath(self::IMAGES[$i]);
            $post->setDescription($faker->paragraph(2));
            $manager->persist($post);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
