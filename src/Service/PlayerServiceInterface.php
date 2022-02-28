<?php

namespace App\Service;
use App\Entity\Player;

interface PlayerServiceInterface{
    /**
     * Creates the player
     */
    public function create(string $data);
    /**
     * GetAll the player
     */
    public function getAll();
    /**
     * Modifiy the player
     */
    public function modify(Player $player, string $data);
    /**
     * Delete the player
     */
    public function delete(Player $player);


    /**
    * Checks if the entity has been well filled
    */
    public function isEntityFilled(Player $player);
    /**
    * Submits the data to hydrate the object
    */
    public function submit(Player $player, $formName, $data);

    /**
    * Gets images randomly using kind
    */public function getImagesKind(string $kind, int $number);

    /**
    * Gets images randomly
    */
    public function getImages(int $number, ?string $kind = null);

}
?>