<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
;

class PersonneFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i<100; $i++)
        {
            $personne = new Users();
            $personne->setFistname($faker->firstName);
            $personne->setName($faker->lastName);
            $personne->setAge($faker->numberBetween(18, 40));

            $manager->persist($personne);
        }

        $manager->flush();
    }
}
