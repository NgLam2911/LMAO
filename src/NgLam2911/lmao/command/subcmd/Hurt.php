<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\args\FloatArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Server;

class Hurt extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.burn");
		$this->registerArgument(0, new PlayerArgument());
		$this->registerArgument(1, new FloatArgument("damage", true));
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
		$damage = $args["damage"] ?? 1;
		$ev = new EntityDamageEvent($player, EntityDamageEvent::CAUSE_CUSTOM, $damage);
		$player->attack($ev);
		$sender->sendMessage($player->getName() . " is now being hurt!");

	}
}