<?php
declare(strict_types=1);

namespace NgLam2911\lmao\session;

use pocketmine\player\Player;

class Session{

	protected Player $player;
	protected bool $is_alone = false;
	protected bool $is_nomine = false;
	protected bool $is_noplace = false;
	protected bool $is_nopick = false;
	protected bool $is_fakelag = false;
	protected bool $is_infiniteDeath = false;

	protected int $no_mine_expire_time = 0;
	protected int $no_place_expire_time = 0;
	protected int $no_pick_expire_time = 0;
	protected int $fakelag_expire_time = 0;
	protected int $infiniteDeath_expire_time = 0;

	protected array $lagged_packets = [];

	public function __construct(Player $player){
		$this->player = $player;
	}

	public function getPlayer() : Player{
		return $this->player;
	}

	public function isAlone() : bool{
		return $this->is_alone;
	}

	public function isNoMine() : bool{
		if($this->is_nomine){
			if($this->no_mine_expire_time < time()){
				$this->setNoMine(false);
			}
		}
		return $this->is_nomine;
	}

	public function isNoPlace() : bool{
		if($this->is_noplace){
			if($this->no_place_expire_time < time()){
				$this->setNoPlace(false);
			}
		}
		return $this->is_noplace;
	}

	public function isNoPick() : bool{
		if($this->is_nopick){
			if($this->no_pick_expire_time < time()){
				$this->setNoPick(false);
			}
		}
		return $this->is_nopick;
	}

	public function isFakeLag() : bool{
		if($this->is_fakelag){
			if($this->fakelag_expire_time < time()){
				$this->setFakeLag(false);
				//Send Lagged packets
				foreach($this->getLaggedPackets() as $packet){
					//NOTHING
				}
			}
		}
		return $this->is_fakelag;
	}

	public function isInfiniteDeath() : bool{
		if($this->is_infiniteDeath){
			if($this->infiniteDeath_expire_time < time()){
				$this->setInfiniteDeath(false);
			}
		}
		return $this->is_infiniteDeath;
	}

	public function setAlone(bool $status = true) : void{
		$this->is_alone = $status;
	}

	public function setNoMine(bool $status = true, int $duration = 0) : void{
		$this->is_nomine = $status;
		if((time() + $duration) > PHP_INT_MAX){ //AVOID A VERY BIG NUMBER :>
			$this->no_mine_expire_time = PHP_INT_MAX;
		}else{
			$this->no_mine_expire_time = time() + $duration;
		}
	}

	public function setNoPlace(bool $status = true, int $duration = 0) : void{
		$this->is_noplace = $status;
		if((time() + $duration) > PHP_INT_MAX){ //AVOID A VERY BIG NUMBER :>
			$this->no_place_expire_time = PHP_INT_MAX;
		}else{
			$this->no_place_expire_time = time() + $duration;
		}
	}

	public function setNoPick(bool $status = true, int $duration = 0) : void{
		$this->is_nopick = $status;
		if((time() + $duration) > PHP_INT_MAX){ //AVOID A VERY BIG NUMBER :>
			$this->no_pick_expire_time = PHP_INT_MAX;
		}else{
			$this->no_pick_expire_time = time() + $duration;
		}
	}

	public function setFakeLag(bool $status = true, int $duration = 0) : void{
		$this->is_fakelag = $status;
		if((time() + $duration) > PHP_INT_MAX){ //AVOID A VERY BIG NUMBER :>
			$this->fakelag_expire_time = PHP_INT_MAX;
		}else{
			$this->fakelag_expire_time = time() + $duration;
		}
	}

	public function setInfiniteDeath(bool $status = true, int $duration = 0) : void{
		$this->is_infiniteDeath = $status;
		if((time() + $duration) > PHP_INT_MAX){ //AVOID A VERY BIG NUMBER :>
			$this->infiniteDeath_expire_time = PHP_INT_MAX;
		}else{
			$this->infiniteDeath_expire_time = time() + $duration;
		}
	}

	public function getLaggedPackets() : array{
		return $this->lagged_packets;
	}

	public function addLaggedPacket($packet) : void{
		$this->lagged_packets[] = $packet;
	}
}