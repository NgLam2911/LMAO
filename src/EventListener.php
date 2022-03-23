<?php
declare(strict_types=1);

namespace lmao;

use lmao\session\Session;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityItemPickupEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;

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
	public function onQuit(PlayerQuitEvent $event) : void{
		$player = $event->getPlayer();
		Lmao::getInstance()->getSessionManager()->removeSession(new Session($player));
	}

	/**
	 * @param BlockBreakEvent $event
	 * @priority LOW
	 * @handleCancelled FALSE
	 */
	public function onBreak(BlockBreakEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isNoMine()){
			$event->cancel();
		}
	}

	/**
	 * @param BlockPlaceEvent $event
	 * @priority LOW
	 * @handleCancelled FALSE
	 */
	public function onPlace(BlockPlaceEvent $event){
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isNoPlace()){
			$event->cancel();
		}
	}

	/**
	 * @param EntityItemPickupEvent $event
	 * @priority LOW
	 * @handleCancelled FALSE
	 */
	public function onPickup(EntityItemPickupEvent $event){
		$entity = $event->getEntity();
		if (!$entity instanceof Player){
			return;
		}
		$session = Lmao::getInstance()->getSessionManager()->getSession();
		if (is_null($session)){
			return;
		}
		if ($session->isNoPick()){
			$event->cancel();
		}
	}
}