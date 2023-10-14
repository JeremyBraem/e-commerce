<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class ProfilFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $profil = new Profil();
        $profil->setUrl('https://www.facebook.com');
        $profil->setRs('Facebook');

        $profil1 = new Profil();
        $profil1->setUrl('https://www.twitter.com');
        $profil1->setRs('Twitter');

        $profil2 = new Profil();
        $profil2->setUrl('https://www.linkedin.com');
        $profil2->setRs('Linkedin');

        $profil3 = new Profil();
        $profil3->setUrl('https://www.github.com');
        $profil3->setRs('GitHub');

        $manager->persist($profil);
        $manager->persist($profil1);
        $manager->persist($profil2);
        $manager->persist($profil3);
        
        $manager->flush();
    }
}
