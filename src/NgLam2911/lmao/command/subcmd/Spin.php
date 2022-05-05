<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\args\FloatArgument;
use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use NgLam2911\lmao\command\args\SpinDirectionArgument;
use NgLam2911\lmao\Lmao;
use NgLam2911\lmao\task\SpinTask;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Spin extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.spin");
		$this->registerArgument(0, new PlayerArgument());
		$this->registerArgument(1, new FloatArgument("speed", true));
		$this->registerArgument(2, new IntegerArgument("times", true));
		$this->registerArgument(3, new SpinDirectionArgument(true));
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
		$speed = $args["speed"] ?? 1;
		$times = $args["times"] ?? 1;
		if (isset($args["spindirection"])){
			$spinDirection = match ($args["spindirection"]) {
				"right" => SpinTask::SPINDIRECTION_RIGHT,
				default => SpinTask::SPINDIRECTION_LEFT //Default value
			};
		} else {
			$spinDirection = SpinTask::SPINDIRECTION_LEFT;
		}
		Lmao::getInstance()->getScheduler()->scheduleRepeatingTask(new SpinTask($player, $speed, $times, $spinDirection), 1);
		$sender->sendMessage($player->getName() . " now spinning at a speed of " . $speed . " for " . $times . " times");
	}
}