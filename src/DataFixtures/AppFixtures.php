<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Instruction;
use App\Entity\WorkSession;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        // Création de 20 utilisateurs
        for ($i=0; $i < 20 ; $i++) { 
            $user = new User();
            $user->setEmail($faker->email())
                 ->setPassword($faker->password())
                 ->setRoles(['ROLE_USER'])
                 ->setFirstname($faker->firstName())
                 ->setLastname($faker->lastName());

            $manager->persist($user);
        }

        $manager->flush();

        $users = $manager->getRepository(User::class)->findAll();


        // Création de 20 Work Session
        for ($t = 0; $t < 20; $t++) {
            // Création d'un nouvel objet Task
            $workSession = new WorkSession;
            $workSession->setStartDate($faker->dateTimeBetween('-6 months'))
                        ->setEndDate($faker->dateTimeBetween('-6 months'))
                        ->setUser($faker->randomElement($users));

            $manager->persist($workSession);
        }

        // Création de 20 tâches
        for ($t = 0; $t < 20; $t++) {
            // Création d'un nouvel objet Task
            $task = new Task;
            $task->setName($faker->sentence())
                 ->setDescription($faker->paragraph())
                 ->setCreatedAt(new DateTime())
                 ->setDueAt($faker->dateTimeBetween('-6 months'))
                 ->setUserId($faker->randomElement($users));

            $manager->persist($task);
        }

        // Création de 20 instructions
        for ($t = 0; $t < 20; $t++) {
            // Création d'un nouvel objet Task
            $instruction = new Instruction;
            $instruction->setName($faker->sentence())
                        ->setDescription($faker->paragraph())
                        ->setDate($faker->dateTimeBetween('-6 months'))
                        ->setUserId($faker->randomElement($users));

            $manager->persist($instruction);
        }



       


        $manager->flush();
    }
}
