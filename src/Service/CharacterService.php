<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CharacterRepository;
use Symfony\Component\Finder\Finder;

class CharacterService implements CharacterServiceInterface{
    private $em;
    private $characterRepository;

    public function __construct(CharacterRepository $characterRepository,EntityManagerInterface $em)
    {
        $this->characterRepository = $characterRepository;
        $this->em = $em;
        
    }

    /**
     * (@inheritdoc)
     */
    public function getAll(){
        $charactersFinal = array();
        $characters = $this->characterRepository->findAll();
        foreach($characters as $character) {
            $charactersFinal[] = $character->toArray();
        }
        return $charactersFinal;
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

    public function modify(Character $character){
        $character
            ->setKind('Seigneur')
            ->setName('Gorthol')
            ->setSurname('Haume de terreur')
            ->setCaste('Chevalier')
            ->setKnowledge('Diplomatie')
            ->setIntelligence(110)
            ->setLife(13)
            ->setImage('/images/gorthol.jpg');
        $this->em->persist($character);
        $this->em->flush();
        return $character;
    }
    public function delete(Character $character){
        $this->em->remove($character);
        $this->em->flush();
        return true;
    }

    /**
    * {@inheritdoc}
    */
    public function getImages(int $number, ?string $kind = null){
        $folder = __DIR__ . '/../../public/images/';
        $finder = new Finder();
        $finder
            ->files()
            ->in($folder)
            ->notPath('/cartes/')
            ->sortByName();
            if (null !== $kind) {
                $finder
                    ->path('/' . $kind . '/');
                }
        $images = array();
        foreach ($finder as $file) {
            $images[] = '/images/' . $file->getPathname();
        }
        shuffle($images);
        return array_slice($images, 0, $number, true);
    }
    
    public function getImagesKind(string $kind, int $number){
        return $this->getImages($number, $kind);
    }
}
?>