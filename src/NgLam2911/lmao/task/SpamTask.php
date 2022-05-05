<?php
declare(strict_types=1);

namespace NgLam2911\lmao\task;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;

class SpamTask extends Task{

	public const SPAMTYPE_NORMAL = 0;
	public const SPAMTYPE_ENCHANTING_TABLE = 1;

	protected const NORMAL_MESSAGES = [
		"dflajdlqwodkoadkaokwodkopasckoako",
		"nosrlv[w0w4it-kvdpbll[pvps[slca,d",
		"929ckvjiojaikifos,cl;a,;kodkospva",
		"asjdioaodjoji90ikcoakcakckkcoakpo",
		"ado3iodkq00o0jskjodlckpakoskkakvc",
		"kluktnxsbwgsdvsvserergrsvsdrfvsfv",
		"ai3oiigodbmm,zncajxzwdqwopkp[qcl;"
	];

	protected const ENCHANTING_TABLE_MESSAGES = [
		"⍑╎ᓭ ╎ᓭ ᓭ!¡ᔑᒲ ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ𝙹ꖎ",
		"𝙹⚍ ᔑ∷ᒷ ⊣ᒷℸ ̣ ℸ ̣ ╎リ⊣ ℸ ̣ ∷𝙹ꖎꖎᒷ↸ᔑᒲ⊣ᒷℸᒲ",
		"リꖎ|| ᔑ ᓵ𝙹⚍!¡ꖎᒷ ᒲ𝙹∷ᒷ ℸ ̣ 𝙹 ⊣𝙹⊣ᒷℸ ̣ ℸ ̣ ",
		"ᔑ↸ᒷ ʖ|| r⚍ᓭ⍑╎ꖎ. H𝙹!¡ᒷ ||𝙹⚍ ꖎ╎ꖌᒷ ╎ℸ ̣  ⍑ᒷ⍑ᒷ",
		"ꖌ, ℸ ̣ ⍑╎ᓭ ╎ᓭ ℸ ̣ ⍑ᒷ ꖎᔑᓭℸ ̣  𝙹⎓ ℸ ̣ ⍑ᒷ ⎓╎⍊ᒷ ᒲᒷᓭᓭᔑ⊣ᒷᓭ"
	];

	protected Player $player;
	protected int $spam_type;
	protected int $messages;
	protected int $count = 0;

	public function __construct(Player $player, int $spam_type = 0, int $messages = 100){
		$this->player = $player;
		$this->spam_type = $spam_type;
		$this->messages = $messages;
	}

	public function onRun() : void{
		if ($this->count >= $this->messages){
			$this->getHandler()->cancel();
			return;
		}
		if (!$this->player->isOnline()){
			$this->getHandler()->cancel();
			return;
		}
		$this->player->sendMessage($this->getSpamMessage());
		$this->count++;
	}

	public function getSpamMessage() : string{
		return match ($this->spam_type) {
			self::SPAMTYPE_NORMAL => self::NORMAL_MESSAGES[array_rand(self::NORMAL_MESSAGES)],
			self::SPAMTYPE_ENCHANTING_TABLE => self::ENCHANTING_TABLE_MESSAGES[array_rand(self::ENCHANTING_TABLE_MESSAGES)],
			default => ""
		};
	}
}