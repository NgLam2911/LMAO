<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\RemoveActorPacket;
use pocketmine\Server;

class Crash extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.crash");
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
		//Create a crash packet (Idea: @NhanAZ)
		$packet = RemoveActorPacket::create($player->getId());
		$player->getNetworkSession()->sendDataPacket($packet);
		$sender->sendMessage($player->getName() . " has been crashed !");
	}
}