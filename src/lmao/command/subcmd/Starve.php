<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\args\FloatArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Starve extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.starve");
		$this->registerArgument(0, new PlayerArgument());
		$this->registerArgument(1, new FloatArgument("amount", true));
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
		if (!isset($args["amount"])){
			$amount = 1;
		} else {
			$amount = $args["seconds"];
		}
		$food = $player->getHungerManager()->getFood();
		if ($food - $amount < 0){
			$player->getHungerManager()->setFood(0);
		} else {
			$player->getHungerManager()->setFood($food - $amount);
		}
		$sender->sendMessage($player->getName() . " is now being starved!");
	}
}