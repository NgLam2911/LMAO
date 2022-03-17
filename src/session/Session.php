<?php
declare(strict_types=1);

namespace lmao\session;

use pocketmine\player\Player;

class Session{

	protected Player $player;
	protected bool $is_alone = false;

	public function __construct(Player $player){
		$this->player = $player;
	}

	public function getPlayer() : Player{
		return $this->player;
	}

	public function isAlone() : bool{
		return $this->is_alone;
	}

	public function setAlone(bool $status) : void{
		$this->is_alone = $status;
	}
}