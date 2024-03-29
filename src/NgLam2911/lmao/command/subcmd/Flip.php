<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Flip extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.flip");
		$this->registerArgument(0, new PlayerArgument());
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		if (!isset($args["player"])){
			$sender->sendMessage("Please add player name !");
			return;
		}
		$player = Server::getInstance()->getPlayerByPrefix($args["player"]);
		if (is_null($player)){
			$sender->sendMessage("Invalid player name !");
			return;
		}
		$newYaw = $player->getLocation()->getYaw() + 180;
		$player->teleport($player->getPosition(), $newYaw);
		$sender->sendMessage($player->getName() . " has been flipped 180!");
	}
}