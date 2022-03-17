<?php
declare(strict_types=1);

namespace lmao;

use lmao\command\LmaoCommand;
use lmao\session\SessionManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Lmao extends PluginBase{
	use SingletonTrait;

	protected SessionManager $sessionManager;

	protected function onLoad() : void{
		self::setInstance($this);
	}

	protected function onEnable() : void{
		$this->sessionManager = new SessionManager();
		$this->getServer()->getCommandMap()->register("lmao", new LmaoCommand($this, "lmao", "lmao command"));
	}

	public function getSessionManager() : SessionManager{
		return $this->sessionManager;
	}
}