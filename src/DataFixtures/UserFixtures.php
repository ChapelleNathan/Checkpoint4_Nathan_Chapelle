<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USERS = 4;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < self::USERS; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setPseudo($user->getFirstname() . '_' . $user->getLastname());
            $user->setPassword($this->passwordHasher->hashPassword($user, $faker->password()));
            $user->setProfilePicture('build/images/placeholder.png');
            $user->setDescription($faker->paragraph(2));
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $john = new User();
        $john->setEmail('john@doe.com');
        $john->setFirstname('John');
        $john->setLastname('Doe');
        $john->setPseudo('John_Doe');
        $john->setDescription('Bonsoir je suis John Doe et je ne sais pas qui je suis. omg...');
        $john->setPassword($this->passwordHasher->hashPassword($john, 'whoami'));
        $john->setProfilePicture('uploads/profilePictures/erinaPP.png');
        copy(__DIR__ . '/erinaPP.png', __DIR__ . '/../../public/uploads/profilePictures/erinaPP.png');
        $this->setReference('user_john', $john);
        $manager->persist($john);

        $manager->flush();
    }
}
