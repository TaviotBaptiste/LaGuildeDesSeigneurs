<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Character;
use Doctrine\DBAL\Driver\Mysqli\Initializer\Charset;
use LogicException;

class CharacterVoter extends Voter
{
    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_INDEX = 'characterIndex';
    public const CHARACTER_MODIFY = 'characterModify';
    public const CHARACTER_DELETE = 'characterDelete';
    public const CHARACTER_INTELLIGENCE = 'characterIntelligence';
    public const CHARACTER_LIFE = 'characterLife';
    public const CHARACTER_CASTE = 'characterCaste';
    public const CHARACTER_KNOWLEDGE = 'characterKnowledge';






    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE,
        self::CHARACTER_INDEX,
        self::CHARACTER_MODIFY,
        self::CHARACTER_DELETE,
        self::CHARACTER_INTELLIGENCE,
        self::CHARACTER_LIFE,
        self::CHARACTER_CASTE,
        self::CHARACTER_KNOWLEDGE


    );

    protected function supports(string $attribute, $subject): bool
    {
        if (null !== $subject) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }

        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, self::ATTRIBUTES);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CHARACTER_DISPLAY:
            case self::CHARACTER_INDEX:
            case self::CHARACTER_INTELLIGENCE:
            case self::CHARACTER_LIFE:
            case self::CHARACTER_CASTE:
            case self::CHARACTER_KNOWLEDGE:
                return $this->canDisplay();
                break;
            case self::CHARACTER_CREATE:
                return $this->canCreate();
                break;
            case self::CHARACTER_MODIFY:
                return $this->canModify();
                break;
            case self::CHARACTER_DELETE:
                return $this->canDelete();
                break;
        }

        throw new LogicException('Invalid attribute : ' . $attribute);
    }

    /*
    * Checks if is allowed to display
    */
    private function canDisplay()
    {
        return true;
    }

    /*
    * Checks if is allowed to create
    */
    private function canCreate()
    {
        return true;
    }

    /*
    * Checks if is allowed to modify
    */
    private function canModify()
    {
        return true;
    }

    /*
    * Checks if is allowed to delete
    */
    private function canDelete()
    {
        return true;
    }
}