<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use App\Entity\Responsable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $departs = ["RH","DEV","DIRECTION","COM","APRES VENTE"];
        $responsables = ["chaymae.abourri@gmail.com","nomprenom@gmail.com",
            "mail3@gmail.com","mail4@gmail.com","mail5@gmail.com"];
        for ($i =0 ; $i < 5; $i++) {

            $dep = new Departement();
            $dep->setNom($departs[$i]);

            $resp = new Responsable();
            $resp->setNom("res".$i);
            $resp->setEmail($responsables[$i]);

            $dep->setResponsable($resp);


            $manager->persist($dep);
            $manager->persist($resp);

        }
        $manager->flush();
    }
}
