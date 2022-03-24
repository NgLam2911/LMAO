<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\args\TextArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Chat extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.chat");
		$this->registerArgument(0, new PlayerArgument());
		$this->registerArgument(1, new TextArgument("message"));
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

		if (!isset($args["message"])){
			$sender->sendMessage("Please add message!");
			return;
		}
		$message = $args["message"];

		$player->chat($message);
		$sender->sendMessage($player->getName() . " is now being forced to chat " . $message);
	}
}