<?php
declare(strict_types=1);

namespace NgLam2911\lmao;

use NgLam2911\lmao\session\Session;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityItemPickupEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\player\Player;
use pocketmine\scheduler\ClosureTask;

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
		$session = Lmao::getInstance()->getSessionManager()->getSession($entity);
		if (is_null($session)){
			return;
		}
		if ($session->isNoPick()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerRespawnEvent $event
	 * @priority LOW
	 */
	public function onRespawn(PlayerRespawnEvent $event){
		$session = Lmao::getInstance()->getSessionManager()->getSession($event->getPlayer());
		if (is_null($session)){
			return;
		}
		if ($session->isInfiniteDeath()){
			Lmao::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function() use ($session) : void {
				$session->getPlayer()->kill();
			}), 3);
		}
	}
}