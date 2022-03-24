<?php
declare(strict_types=1);

namespace lmao;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
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
		try{
			if(!PacketHooker::isRegistered()){
				PacketHooker::register($this);
			}
		}catch(HookAlreadyRegistered){
			//NOOP
		}
		$this->sessionManager = new SessionManager();
		$this->getServer()->getCommandMap()->register("lmao", new LmaoCommand($this, "lmao", "lmao command"));
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
	}

	public function getSessionManager() : SessionManager{
		return $this->sessionManager;
	}
}