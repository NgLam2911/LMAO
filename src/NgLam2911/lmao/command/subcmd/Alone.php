<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use NgLam2911\lmao\Lmao;
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
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			$sender->sendMessage("Can't get player session !");
			return;
		}
		if (!$session->isAlone()){
			foreach(Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
				$onlinePlayer->hidePlayer($player);
			}
			$sender->sendMessage($player->getName() . " is now alone !");
			$session->setAlone(true);
		} else {
			foreach(Server::getInstance()->getOnlinePlayers() as $onlinePlayer){
				$onlinePlayer->showPlayer($player);
			}
			$sender->sendMessage($player->getName() . " is no longer alone !");
			$session->setAlone(false);
		}
	}
}