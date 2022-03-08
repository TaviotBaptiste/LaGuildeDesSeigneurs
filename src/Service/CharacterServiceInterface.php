<?php

namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Creates the character
     */

    public function create(string $data);
    public function getAll();
    public function modify(Character $character, string $data);
    public function delete(Character $character);
    /**
    * Checks if the entity has been well filled
    */
    public function isEntityFilled(Character $character);
    /**
    * Submits the data to hydrate the object
    */
    public function submit(Character $character, $formName, $data);

    /**
    * Gets images randomly using kind
    */public function getImagesKind(string $kind, int $number);

    /**
    * Gets images randomly
    */
    public function getImages(int $number, ?string $kind = null);
    /**
    * Creates the character from html form
    */
    public function createFromHtml(Character $character);
}
