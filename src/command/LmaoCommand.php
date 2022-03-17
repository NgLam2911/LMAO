<?php
declare(strict_types=1);

namespace lmao\command;

use CortexPE\Commando\BaseCommand;
use lmao\command\subcmd\Burn;
use lmao\command\subcmd\FakeOP;
use pocketmine\command\CommandSender;

class LmaoCommand extends BaseCommand{

	protected function prepare() : void{
		$this->setPermission("lmao");
		$this->registerSubCommand(new Burn("burn", "Burn other player"));
		$this->registerSubCommand(new FakeOP("fakeop", "Sends an op message to the victim. They are not opped..."));
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		$sender->sendMessage("Usage: /lmao help");
	}
}