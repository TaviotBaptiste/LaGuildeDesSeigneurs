<?php

namespace App\Listener;

use App\Event\PlayerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PlayerListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(PlayerEvent::PLAYER_MODIFY => 'playerCreated',);
    }
    public function playerModify($event)
    {
        $lessMoney = 10;
        $player = $event->getPlayer();
        $player->setMirian($player->getMirian()-$lessMoney);
    }
}
