<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use lmao\Lmao;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Alone extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.alone");
		$this->registerArgument(0, new PlayerArgument());
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		if (!isset($args["player"])){
			$sender->sendMessage("Please add player name !");
			return;
		}
		$player = Server::getInstance()->getPlayerByPrefix($args["player"]);
		if (is_null($player)){
			$sender->sendMessage("Invalid player !");
			return;
		}
		if (!Lmao::getInstance()->getSessionManager()->getSession($player)->isAlone()){
			foreach(Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
				$onlinePlayer->hidePlayer($player);
			}
			$sender->sendMessage($player->getName() . " is now alone !");
		} else {
			foreach(Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
				$onlinePlayer->showPlayer($player);
			}
			$sender->sendMessage($player->getName() . " is no longer alone !");
		}
	}
}