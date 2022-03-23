<?php
declare(strict_types=1);

namespace lmao\command\args;

use CortexPE\Commando\args\StringEnumArgument;
use pocketmine\command\CommandSender;

class SpinDirectionArgument extends StringEnumArgument{

	public function __construct(bool $optional = false){
		parent::__construct("spindirection", $optional);
	}

	public function parse(string $argument, CommandSender $sender) : string{
		return $argument;
	}

	public function getEnumValues() : array{
		return ["left", "right"];
	}

	public function getTypeName() : string{
		return $this->name;
	}
}