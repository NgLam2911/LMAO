<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class Swap extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.swap");
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
		if (!$sender instanceof Player){
			$sender->sendMessage("Please use this feature in-game !");
			return;
		}
		$basePos = $sender->getPosition();
		$sender->teleport($player->getPosition());
		$player->teleport($basePos);
		$sender->sendMessage("You have swaped positions with " . $player->getName());
	}
}