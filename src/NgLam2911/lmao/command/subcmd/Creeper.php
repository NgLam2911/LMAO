<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\Server;

class Creeper extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.creeper");
		$this->registerArgument(0, new PlayerArgument());
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
		$sound = new PlaySoundPacket();
		$sound->x = $player->getPosition()->x;
		$sound->y = $player->getPosition()->y;
		$sound->z = $player->getPosition()->z;
		$sound->volume = 20;
		$sound->pitch = 1;
		$sound->soundName = "mob.creeper.say";
		Server::getInstance()->broadcastPackets($player->getWorld()->getPlayers(), [$sound]);
		$sender->sendMessage($player->getName() . " is now hearing creeper sounds!");
	}
}