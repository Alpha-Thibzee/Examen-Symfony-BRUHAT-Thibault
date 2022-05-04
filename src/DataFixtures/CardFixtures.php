<?php

namespace App\DataFixtures;

use App\Entity\Card;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for( $i = 1 ; $i < 13 ; $i++){
            $card = new Card();
            $card->setName("Carte n°".$i);
            $card->setQuantity($i);
            $card->setValue($i*20);
            $card->setPicture($i.".png");
            $card->setBuyAt(new \DateTimeImmutable());
            $card->setReleaseAt(new \DateTimeImmutable());  
            if ($i % 2){
                $card->setIsOnSale(true);
            } else {
                $card->setIsOnSale(false);
            }
            $card->setDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.");
            
            $manager->persist($card);
        }
        

        $manager->flush();
    }
}
