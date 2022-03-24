<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class FakeDeop extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.fakedeop");
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
		$player->sendMessage('§7You are no longer op!');
		$sender->sendMessage("Sending Fake Deop message to " . $player->getName());
	}
}