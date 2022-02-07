<?php

namespace App\Security\Voter;

use App\Entity\Character;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use LogicException;
use Prophecy\Argument\Token\TokenInterface as TokenTokenInterface;

class CharacterVoter extends Voter
{
    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_CREATE = 'characterCreate';

    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE,
    );
    protected function supports ($attribute, $subject){
        if (null !== $subject) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }
        return in_array($attribute, self::ATTRIBUTES);
    }

    public function voteOnAttributs($attribute, $subject,TokenTokenInterface $token){
        //Defines acces rights
        switch($attribute){
            case self::CHARACTER_DISPLAY:
                //Peut envoyer $token et $subject pour tester des conditions
                return $this->canDisplay();
                break;
            case self::CHARACTER_CREATE:
                //Peut envoyer $token et $subject pour tester des conditions
                return $this->canCreate();
                break;

        }
        throw new LogicException('Invalid attribute: ' . $attribute);
    }
    /**
     * Checks if is allow to display
     */
    private function canDisplay(){
        return true;
    }
    private function canCreate(){
        return true;
    }
}
