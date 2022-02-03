<?php

namespace App\DataFixtures;

use App\Entity\Comments;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < UserFixtures::USERS; $i++) {
            $comments = rand(2, 9);
            for ($j = 0; $j < $comments; $j++) {
                $comment = new Comments();
                $comment->setUser($this->getReference('user_' . $i));
                $sentences = rand(1, 3);
                $comment->setComment($faker->paragraph($sentences));
                $post = rand(0, PostFixtures::POSTS - 1);
                $comment->setPost($this->getReference('post_' . $post));
                $manager->persist($comment);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PostFixtures::class,
        ];
    }
}
