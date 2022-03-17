<?php
declare(strict_types=1);

namespace lmao\session;

use pocketmine\player\Player;

class SessionManager{

	/** @var Session[] */
	protected array $sessions = [];

	public function registerSession(Session $session, bool $overwrite = false) : void{
		if (is_null($this->getSession($session->getPlayer()) && $overwrite)){
			$this->sessions[$session->getPlayer()->getUniqueId()->toString()] = $session;
		} else {
			throw new \RuntimeException("Can't overwrite existing session");
		}
	}

	public function getSession(Player $player) : ?Session{
		if (isset($this->sessions[$player->getUniqueId()->toString()])){
			return $this->sessions[$player->getUniqueId()->toString()];
		}
		return null;
	}

	public function removeSession(Player|Session $player){
		if ($player instanceof Session){
			$player = $player->getPlayer();
		}
		if (!is_null($this->getSession($player))){
			unset($this->sessions[$player->getUniqueId()->toString()]);
		}
	}
}