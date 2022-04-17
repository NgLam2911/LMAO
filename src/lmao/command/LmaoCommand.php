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
use lmao\command\subcmd\Creeper;
use lmao\command\subcmd\DropInv;
use lmao\command\subcmd\FakeBan;
use lmao\command\subcmd\FakeDeop;
use lmao\command\subcmd\FakeOP;
use lmao\command\subcmd\Flip;
use lmao\command\subcmd\Hurt;
use lmao\command\subcmd\InfiniteDeath;
use lmao\command\subcmd\Launch;
use lmao\command\subcmd\NoMine;
use lmao\command\subcmd\NoPick;
use lmao\command\subcmd\NoPlace;
use lmao\command\subcmd\PumkinHead;
use lmao\command\subcmd\PumpkinHead;
use lmao\command\subcmd\Push;
use lmao\command\subcmd\Rickroll;
use lmao\command\subcmd\Shuffle;
use lmao\command\subcmd\Spam;
use lmao\command\subcmd\Spin;
use lmao\command\subcmd\Starve;
use lmao\command\subcmd\Swap;
use pocketmine\command\CommandSender;

class LmaoCommand extends BaseCommand{

	protected function prepare() : void{
		$this->setPermission("lmao");
		$this->registerSubCommand(new Burn("burn", "Burn the player"));
		$this->registerSubCommand(new FakeOP("fakeop", "Sends an op message to the player. They are not opped..."));
		$this->registerSubCommand(new Launch("launch", "3... 2... 1... liftoff!"));
		$this->registerSubCommand(new Alone("alone", "Hides every player, let them feed alone!"));
		$this->registerSubCommand(new Bolt("bolt", "The player is really feeling the wrath of the God of lightning!"));
		$this->registerSubCommand(new Crash("crash", "Kicks player with a not so nice disconnected message"));
		$this->registerSubCommand(new FakeDeop("fakedeop", "Sends a deop message to the player. They are not deopped..."));
		$this->registerSubCommand(new Shuffle("shuffle", "Shuffle player's inventory :>"));
		$this->registerSubCommand(new Push("push", "An uncontrolled flight..."));
		$this->registerSubCommand(new Hurt("hurt", "Ouch! That hurts..."));
		$this->registerSubCommand(new Boom("boom", "Blow up the player!"));
		$this->registerSubCommand(new DropInv("dropinv", "Drop player's inventory!"));
		$this->registerSubCommand(new Chat("chat", "Sends a chat message or run a command on behalf of the player!"));
		$this->registerSubCommand(new FakeBan("fakeban", "Are you sure you got banned ?"));
		$this->registerSubCommand(new Flip("flip", "Flip the player 180 degrees!"));
		$this->registerSubCommand(new Spin("spin", "You spin me right round ..."));
		$this->registerSubCommand(new Swap("swap", "Swap postion with the player!"));
		$this->registerSubCommand(new Spam("spam", "Spam the player's chat"));
		$this->registerSubCommand(new Creeper("creeper", "Something is behind you ???"));
		$this->registerSubCommand(new NoMine("nomine", "Can't mine blocks ??? Maybe lag."));
		$this->registerSubCommand(new NoPlace("noplace", "Can't place blocks ??? Maybe lag."));
		$this->registerSubCommand(new NoPick("nopick", "Can't pickup items ??? Maybe lag."));
		$this->registerSubCommand(new Rickroll("rickroll", "Rolling with Rick ??? Never gonna give you up"));
		$this->registerSubCommand(new PumpkinHead("pumpkinhead", "Just a pumpkin in ur head..."));
		$this->registerSubCommand(new Starve("starve", "s t a r v e"));
		$this->registerSubCommand(new InfiniteDeath("infinitedeath", "They can't respawn now ..."));
	}
	
	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		$subCommands = $this->getSubCommands();
		foreach($subCommands as $subCommand){
			$sender->sendMessage("/lmao " . $subCommand->getName() . ": " . $subCommand->getDescription());
		}
	}
}