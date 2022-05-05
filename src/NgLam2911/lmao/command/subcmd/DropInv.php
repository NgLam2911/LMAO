<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\Server;

class DropInv extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.dropinv");
		$this->registerArgument(0, new PlayerArgument());
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		if(!isset($args["player"])){
			$sender->sendMessage("Please add player name !");
			return;
		}
		$player = Server::getInstance()->getPlayerByPrefix($args["player"]);
		if(is_null($player)){
			$sender->sendMessage("Invalid player name !");
			return;
		}

		foreach($player->getInventory()->getContents() as $item){
			$player->getWorld()->dropItem($player->getPosition(), $item, new Vector3(mt_rand(-100, 100) / 100, mt_rand(-100, 100) / 100, mt_rand(-100, 100) / 100));
		}
		$player->getInventory()->clearAll();
		foreach($player->getArmorInventory()->getContents() as $item){
			$player->getWorld()->dropItem($player->getPosition(), $item, new Vector3(mt_rand(-100, 100) / 100, mt_rand(-100, 100) / 100, mt_rand(-100, 100) / 100));
		}
		$player->getArmorInventory()->clearAll();
		foreach($player->getOffHandInventory()->getContents() as $item){
			$player->getWorld()->dropItem($player->getPosition(), $item, new Vector3(mt_rand(-100, 100) / 100, mt_rand(-100, 100) / 100, mt_rand(-100, 100) / 100));
		}
		$player->getOffHandInventory()->clearAll();

		$sender->sendMessage($player->getName() . "'s inventory has been dropped!");
	}
}