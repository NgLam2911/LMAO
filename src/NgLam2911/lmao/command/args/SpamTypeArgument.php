<?php
declare(strict_types=1);

namespace NgLam2911\lmao\command\args;

use CortexPE\Commando\args\StringEnumArgument;
use pocketmine\command\CommandSender;

class SpamTypeArgument extends StringEnumArgument{

	public function __construct(bool $optional = false){
		parent::__construct("spamtype", $optional);
	}

	public function parse(string $argument, CommandSender $sender) : string{
		return $argument;
	}

	public function getEnumValues() : array{
		return ["normal", "enchanting_table"];
	}

	public function getTypeName() : string{
		return $this->name;
	}
}