<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_En');

        for($i = 0; $i<10; $i++)
        {
            $job = new Job();
            $job->setDesignation($faker->phoneNumber);

            $manager->persist($job);
        }

        $manager->flush();
    }
}
