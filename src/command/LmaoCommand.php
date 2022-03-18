<?php
declare(strict_types=1);

namespace lmao\command;

use CortexPE\Commando\BaseCommand;
use lmao\command\subcmd\Alone;
use lmao\command\subcmd\Bolt;
use lmao\command\subcmd\Boom;
use lmao\command\subcmd\Burn;
use lmao\command\subcmd\Chat;
use lmao\command\subcmd\Crash;
use lmao\command\subcmd\DropInv;
use lmao\command\subcmd\FakeDeop;
use lmao\command\subcmd\FakeOP;
use lmao\command\subcmd\Hurt;
use lmao\command\subcmd\Launch;
use lmao\command\subcmd\Push;
use lmao\command\subcmd\Shuffle;
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
		$this->registerSubCommand(new FakeDeop("fakedeop", "Sends a deop message to the player. They are not deopped..."));
		$this->registerSubCommand(new Shuffle("shuffle", "Shuffle player inventory :>"));
		$this->registerSubCommand(new Push("push", "An uncontrolled flight..."));
		$this->registerSubCommand(new Hurt("hurt", "Ouch! That hurts..."));
		$this->registerSubCommand(new Boom("boom", "Blow up the player!"));
		$this->registerSubCommand(new DropInv("dropinv", "Drop player inventory!"));
		$this->registerSubCommand(new Chat("chat", "Sends a chat message or run a command on behalf of the player!"));
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		$sender->sendMessage("Usage: /lmao help");
	}
}