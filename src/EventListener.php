<?php
declare(strict_types=1);

namespace lmao;

use lmao\session\Session;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener{

	/**
	 * @param PlayerJoinEvent $event
	 * @priority HIGHEST
	 */
	public function onJoin(PlayerJoinEvent $event) : void{
		$player = $event->getPlayer();
		Lmao::getInstance()->getSessionManager()->registerSession(new Session($player));
	}

	/**
	 * @param PlayerQuitEvent $event
	 * @priority HIGHEST
	 */
	public function onQuit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		Lmao::getInstance()->getSessionManager()->removeSession(new Session($player));
	}
}