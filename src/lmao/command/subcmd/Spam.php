<?php
declare(strict_types=1);

namespace lmao\command\subcmd;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use lmao\command\args\PlayerArgument;
use lmao\command\args\SpamTypeArgument;
use lmao\Lmao;
use lmao\task\SpamTask;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Spam extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.spam");
		$this->registerArgument(0, new PlayerArgument());
		$this->registerArgument(1, new SpamTypeArgument(true));
		$this->registerArgument(2, new IntegerArgument("messages", true));
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
		if (isset($args["spamtype"])){
			$spamtype = match ($args["spamtype"]) {
				"enchanting_table" => SpamTask::SPAMTYPE_ENCHANTING_TABLE,
				default => SpamTask::SPAMTYPE_NORMAL //Default value
			};
		} else {
			$spamtype = SpamTask::SPAMTYPE_NORMAL;
		}
		$messages = $args["messages"] ?? 100;
		Lmao::getInstance()->getScheduler()->scheduleRepeatingTask(new SpamTask($player, $spamtype, $messages), 1);
		$sender->sendMessage($player->getName() . " is being spammed!");
	}
}