<?php

namespace App\Service;
use App\Entity\Character;

interface CharacterServiceInterface{
    /**
     * Creates the character
     */
    public function create();
    public function getAll();
    public function modify(Character $character);
    public function delete(Character $character);

    /**
    * Gets images randomly using kind
    */public function getImagesKind(string $kind, int $number);

    /**
    * Gets images randomly
    */
    public function getImages(int $number, ?string $kind = null);


}
?>