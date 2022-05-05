<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Burn extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.burn");
		$this->registerArgument(0, new PlayerArgument());
		$this->registerArgument(1, new IntegerArgument("seconds", true));
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		if (!isset($args["player"])){
			$sender->sendMessage("Please add player name !");
			return;
		}
		$player = Server::getInstance()->getPlayerByPrefix($args["player"]);
		if ($player == null){
			$sender->sendMessage("Invalid player name !");
			return;
		}
		if (!isset($args["seconds"])){
			$time = 1;
		} else {
			$time = $args["seconds"];
		}
		$player->setOnFire($time);
		$sender->sendMessage("Burned " . $player->getName() . " for " . $time . " seconds !");
	}
}