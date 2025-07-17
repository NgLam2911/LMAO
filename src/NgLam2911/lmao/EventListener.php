<?php
declare(strict_types=1);

namespace NgLam2911\lmao;

use NgLam2911\lmao\session\Session;
use pocketmine\block\tile\Chest as ChestTile;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityItemPickupEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerToggleFlightEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\event\player\PlayerToggleSprintEvent;
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
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param BlockPlaceEvent $event
	 * @priority LOW
	 * @handleCancelled FALSE
	 */
	public function onPlace(BlockPlaceEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isNoPlace()){
			$event->cancel();
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param EntityItemPickupEvent $event
	 * @priority LOW
	 * @handleCancelled FALSE
	 */
	public function onPickup(EntityItemPickupEvent $event) : void{
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
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerRespawnEvent $event
	 * @priority LOW
	 */
	public function onRespawn(PlayerRespawnEvent $event) : void{
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

	/**
	 * @param PlayerMoveEvent $event
	 * @priority HIGHEST
	 * @handleCancelled FALSE
	 */
	public function onMove(PlayerMoveEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerInteractEvent $event
	 * @priority HIGHEST
	 * @handleCancelled FALSE
	 */
	public function onInteract(PlayerInteractEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerDropItemEvent $event
	 * @priority HIGHEST
	 * @handleCancelled FALSE
	 */
	public function onDropItem(PlayerDropItemEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerItemUseEvent $event
	 * @priority HIGHEST
	 * @handleCancelled FALSE
	 */
	public function onItemUse(PlayerItemUseEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerItemHeldEvent $event
	 * @priority HIGHEST
	 * @handleCancelled FALSE
	 */
	public function onItemHeld(PlayerItemHeldEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerToggleSneakEvent $event
	 * @priority HIGHEST
	 * @handleCancelled FALSE
	 */
	public function onToggleSneak(PlayerToggleSneakEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerToggleSprintEvent $event
	 * @priority HIGHEST
	 * @handleCancelled FALSE
	 */
	public function onToggleSprint(PlayerToggleSprintEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}

	/**
	 * @param PlayerToggleFlightEvent $event
	 * @priority HIGHEST
	 * @handleCancelled FALSE
	 */
	public function onToggleFlight(PlayerToggleFlightEvent $event) : void{
		$player = $event->getPlayer();
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			return;
		}
		if ($session->isFrozen()){
			$event->cancel();
		}
	}
}