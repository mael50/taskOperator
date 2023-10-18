<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        for ($t = 0; $t < mt_rand(50, 60); $t++) {
            // Création d'un nouvel objet Task
            $task = new Task;

            // On nourrit l'objet Task
            $task->setName($faker->sentence(6))
                ->setDescription($faker->paragraph(3))
                ->setCreatedAt(new \DateTime()) // Attention les dates sont créés en fonction du réglage serveur
                ->setDueAt(DateTime::createFromFormat('Y-m-d H:i:s', $faker->date('Y-m-d').' '.$faker->time('H:i:s')));


            // On fait persister les données
            $manager->persist($task);
        }

        // Création de 10 utilisateurs
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
    }
}
