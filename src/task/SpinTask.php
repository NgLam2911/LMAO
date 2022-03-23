<?php
declare(strict_types=1);

namespace lmao\task;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;

class SpinTask extends Task{
	public const SPINDIRECTION_LEFT = 0;
	public const SPINDIRECTION_RIGHT = 1;

	protected Player $player;
	protected float $angle = 0;
	protected float $speed;
	protected float $baseYaw;
	protected int $times;
	protected int $spinDirection;

	public function __construct(Player $player, float $speed = 1, int $times = 1, int $spinDirection = 0){
		$this->player = $player;
		$this->speed = $speed;
		$this->times = $times;
		$this->spinDirection = $spinDirection;
		$this->baseYaw = $player->getLocation()->getYaw();
	}

	public function onRun() : void{
		if (!$this->player->isOnline()){
			$this->getHandler()->cancel();
			return;
		}
		if ($this->angle > 360){
			if ($this->times > 1){
				$this->angle = 0;
				$this->times--;
			} else {
				$this->getHandler()->cancel();
			}
		}
		$this->angle += 1.8 * $this->speed;
		if ($this->spinDirection === self::SPINDIRECTION_LEFT){
			$newYaw = -$this->angle + $this->baseYaw;
		} else {
			$newYaw = $this->angle + $this->baseYaw;
		}
		$this->player->teleport($this->player->getPosition(), $newYaw);
	}
}