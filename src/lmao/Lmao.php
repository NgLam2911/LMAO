<?php
declare(strict_types=1);

namespace lmao;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use Exception;
use lmao\command\LmaoCommand;
use lmao\session\SessionManager;
use lmao\task\PlaySongTask;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use xenialdan\libnbs\NBSFile;
use xenialdan\libnbs\Song;

class Lmao extends PluginBase{
	use SingletonTrait;

	protected SessionManager $sessionManager;

	protected ?Song $rickroll;

	protected function onLoad() : void{
		self::setInstance($this);
	}

	protected function onEnable() : void{
		$this->saveResource("Rickroll.nbs");
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
		$this->initSong();
	}
	public function getSessionManager() : SessionManager{
		return $this->sessionManager;
	}

	protected function initSong() : void{
		try{
			$this->rickroll = NBSFile::parse($this->getDataFolder() . DIRECTORY_SEPARATOR . "Rickroll.nbs");
		} catch(Exception){
			$this->rickroll = null;
		}
	}

	public function Rickroll(Player $player) : bool{
		if (is_null($this->rickroll)){
			return false;
		}
		$this->getScheduler()->scheduleRepeatingTask(new PlaySongTask($player, $this->rickroll), intval(floor($this->rickroll->getDelay())));
		return true;
	}
}