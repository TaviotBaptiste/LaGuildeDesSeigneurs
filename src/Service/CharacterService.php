<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;

class CharacterService implements CharacterServiceInterface{
    /**
     * (@inheritdoc)
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        
    }
    public function create(){
        $character = new Character();
        $character
            ->setKind("Il")
            ->setName("Simon Parrot")
            ->setSurname("Le premier de promo")
            ->setCaste("Humour")
            ->setKnowledge("Bibliothèque")
            ->setIntelligence(120)
            ->setLife(7)
            ->setImage("/images/pikachu.jpeg")
            ->setCreation(new \DateTime())
            ->setIdentifier(hash("sha1",uniqid()));

            $this->em->persist($character);
            $this->em->flush();
    return $character;
    }
}
?>