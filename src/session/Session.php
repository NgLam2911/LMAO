<?php
declare(strict_types=1);

namespace lmao\session;

use pocketmine\player\Player;

class Session{

	protected Player $player;

	public function __construct(Player $player){
		$this->player = $player;
	}

	public function getPlayer() : Player{
		return $this->player;
	}
}