<?php
declare(strict_types=1);

namespace lmao;

use lmao\command\LmaoCommand;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase{

	protected function onEnable() : void{
		$this->getServer()->getCommandMap()->register("lmao", new LmaoCommand($this, "lmao", "lmao command"));
	}
}