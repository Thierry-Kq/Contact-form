<?php

namespace App\DataFixtures;

use App\Entity\ContactMessage;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();

        for ($i = 1; $i <= 10; $i++)
        {
            $contactName = 'Visiteur' . $i;
            $contactEmail = $contactName . '@gmail.com';
            
           for ($j = 1; $j <= 2; $j++){
                $contactMessage = new ContactMessage;

                $contactMessage
                    ->setFromEmail($contactEmail)
                    ->setFromName($contactName)
                    ->setContent('Contenu du message n°' . $j .  ' de ' . $contactName)
                    ->setSlug($slugger->slug($contactEmail));
                    $manager->persist($contactMessage);  
           }
        }

        $manager->flush();
    }
}
