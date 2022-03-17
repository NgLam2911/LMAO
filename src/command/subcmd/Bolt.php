<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\Server;

class Bolt extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.bolt");
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

		$id = Entity::nextRuntimeId();
		$lightning = new AddActorPacket();
		$lightning->type = "minecraft:lightning_bolt";
		$lightning->actorRuntimeId = $id;
		$lightning->actorUniqueId = $id; //???
		$lightning->metadata = [];
		$lightning->position = $player->getPosition();
		$lightning->yaw = 0;
		$lightning->pitch = 0;

		$sound = new PlaySoundPacket();
		$sound->x = $player->getPosition()->x;
		$sound->y = $player->getPosition()->y;
		$sound->z = $player->getPosition()->z;
		$sound->volume = 100;
		$sound->pitch = 2;
		$sound->soundName = "ambient.weather.thunder";

		Server::getInstance()->broadcastPackets($player->getWorld()->getPlayers(), [$lightning, $sound]);
		//Add damage
		$ev = new EntityDamageEvent($player, EntityDamageEvent::CAUSE_CUSTOM, 5);
		$player->attack($ev);
		$sender->sendMessage($player->getName() . "has been struck with a lightning bolt!");
	}
}