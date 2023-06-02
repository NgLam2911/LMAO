<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\CommandSender;
use pocketmine\item\VanillaItems;
use pocketmine\Server;

class PumpkinHead extends BaseSubCommand{
	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.pumpkinhead");
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
		$armorinv = $player->getArmorInventory();
		$helmet = $armorinv->getHelmet();
		if ($helmet->equals(VanillaItems::AIR())){
			if ($player->getInventory()->canAddItem($armorinv->getHelmet())){
				$player->getInventory()->addItem($helmet);
			} else {
				$player->getWorld()->dropItem($player->getPosition(), $helmet);
			}
		}
		$armorinv->setHelmet(VanillaBlocks::CARVED_PUMPKIN()->asItem());
		$sender->sendMessage($player->getName() . " now had a pumpkin head!");
	}
}