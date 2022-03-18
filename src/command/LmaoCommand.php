<?php
declare(strict_types=1);

namespace lmao\command;

use CortexPE\Commando\BaseCommand;
use lmao\command\subcmd\Alone;
use lmao\command\subcmd\Bolt;
use lmao\command\subcmd\Burn;
use lmao\command\subcmd\Crash;
use lmao\command\subcmd\FakeOP;
use lmao\command\subcmd\Launch;
use pocketmine\command\CommandSender;

class LmaoCommand extends BaseCommand{

	protected function prepare() : void{
		$this->setPermission("lmao");
		$this->registerSubCommand(new Burn("burn", "Burn other player"));
		$this->registerSubCommand(new FakeOP("fakeop", "Sends an op message to the victim. They are not opped..."));
		$this->registerSubCommand(new Launch("launch", "3... 2... 1... liftoff!"));
		$this->registerSubCommand(new Alone("alone", "Hides every player for the player!"));
		$this->registerSubCommand(new Bolt("bolt", "The player is really feeling the wrath of the God of lightning!"));
		$this->registerSubCommand(new Crash("crash", "Kicks player with a not so nice disconnected message"));
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		$sender->sendMessage("Usage: /lmao help");
	}
}