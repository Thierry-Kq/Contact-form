<?php

namespace App\DataFixtures;

use App\Entity\ContactMessage;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;


class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
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
                    ->setSlug($this->slugger->slug($contactEmail));
                    $manager->persist($contactMessage);  
           }
        }

        $manager->flush();
    }
}
