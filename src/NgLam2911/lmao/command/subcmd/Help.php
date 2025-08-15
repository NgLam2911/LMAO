<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\subcmd;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use NgLam2911\lmao\command\args\PlayerArgument;
use NgLam2911\lmao\Lmao;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Help extends BaseSubCommand{

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare() : void{
		$this->setPermission("lmao.help");
		$this->registerArgument(0, new IntegerArgument("page", true));
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
		$page = (int)($args["page"] ?? 1);
		$commandsPerPage = 10;
		
		$commands = [
			"§a/lmao alone <player> §7- Hides every player, let them feed alone!",
			"§a/lmao bolt <player> §7- The player is really feeling the wrath of the God of lightning!",
			"§a/lmao boom <player> §7- Blow up the player!",
			"§a/lmao burn <player> §7- Burn the player",
			"§a/lmao chat <player> <message> §7- Sends a chat message or run a command on behalf of the player!",
			"§a/lmao crash <player> §7- Kicks player with a not so nice disconnected message",
			"§a/lmao creeper <player> §7- Something is behind you ???",
			"§a/lmao dropinv <player> §7- Drop player's inventory!",
			"§a/lmao fakeban <player> §7- Are you sure you got banned ?",
			"§a/lmao fakedeop <player> §7- Sends a deop message to the player. They are not deopped...",
			"§a/lmao fakeop <player> §7- Sends an op message to the player. They are not opped...",
			"§a/lmao flip <player> §7- Flip the player 180 degrees!",
			"§a/lmao freeze <player> [seconds] §7- Freeze the player for a certain amount of time.",
			"§a/lmao help [page] §7- Show this help message",
			"§a/lmao hurt <player> §7- Ouch! That hurts...",
			"§a/lmao infinitedeath <player> §7- They can't respawn now ...",
			"§a/lmao launch <player> §7- 3... 2... 1... liftoff!",
			"§a/lmao nomine <player> §7- Can't mine blocks ??? Maybe lag.",
			"§a/lmao nopick <player> §7- Can't pickup items ??? Maybe lag.",
			"§a/lmao noplace <player> §7- Can't place blocks ??? Maybe lag.",
			"§a/lmao pumpkinhead <player> §7- Just a pumpkin in ur head...",
			"§a/lmao push <player> §7- An uncontrolled flight...",
			"§a/lmao rickroll <player> §7- Rolling with Rick ??? Never gonna give you up",
			"§a/lmao shuffle <player> §7- Shuffle player's inventory :>",
			"§a/lmao spam <player> <message> §7- Spam the player's chat",
			"§a/lmao spin <player> §7- You spin me right round ...",
			"§a/lmao starve <player> §7- s t a r v e",
			"§a/lmao swap <player> §7- Swap position with the player!"
		];
		
		$totalPages = (int)ceil(count($commands) / $commandsPerPage);
		
		if($page < 1 || $page > $totalPages){
			$page = 1;
		}
		
		$startIndex = ($page - 1) * $commandsPerPage;
		$endIndex = min($startIndex + $commandsPerPage, count($commands));
		
		$sender->sendMessage("§6=== LMAO Commands (Page $page/$totalPages) ===");
		
		for($i = $startIndex; $i < $endIndex; $i++){
			$sender->sendMessage($commands[$i]);
		}
		
		if($totalPages > 1){
			$sender->sendMessage("§6Use §e/lmao help <page> §6to view other pages");
		}
		
		$sender->sendMessage("§6==========================================");
	}
}