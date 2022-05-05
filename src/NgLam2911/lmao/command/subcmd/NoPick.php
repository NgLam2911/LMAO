<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use NgLam2911\lmao\Lmao;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class NoPick extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.nopick");
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
		$session = Lmao::getInstance()->getSessionManager()->getSession($player);
		if (is_null($session)){
			$sender->sendMessage("Can't get player session !");
			return;
		}
		$session->setNoPick(true, $time);
		$sender->sendMessage($player->getName() . " can't pickup items for " . $time . " seconds !");
	}
}