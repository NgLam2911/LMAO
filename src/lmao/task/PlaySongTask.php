<?php
declare(strict_types=1);

namespace lmao\task;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use xenialdan\libnbs\NBSFile;
use xenialdan\libnbs\Song;

class PlaySongTask extends Task{

	public Player $player;
	public Song $song;
	protected bool $playing = false;
	protected int $tick = -1;

	public function __construct(Player $player, Song $song){
		$this->player = $player;
		$this->song = $song;
		$this->playing = true;
	}

	public function onRun() : void{
		if(!$this->playing){
			$this->getHandler()->cancel();
			return;
		}
		if($this->tick > $this->song->getLength()){
			$this->tick = -1;
			$this->playing = false;
			return;
		}
		if (!$this->player->isOnline()){
			$this->getHandler()->cancel();
			return;
		}
		$this->tick++;
		$this->playTick();
	}

	protected function playTick() : void{
		foreach($this->song->getLayerHashMap() as $layer){
			$note = $layer->getNote($this->tick);
			if (is_null($note)){
				continue;
			}
			$volume = ($layer->getVolume() * 50) / 10000;
			$pitch = 2 ** (($note->getKey() - 45) / 12);
			$sound = NBSFile::MAPPING[$note->instrument] ?? NBSFile::MAPPING[NBSFile::INSTRUMENT_PIANO];
			//Create play sound packet
			$packet = new PlaySoundPacket();
			$packet->soundName = $sound;
			$packet->pitch = $pitch;
			$packet->volume = $volume;
			$pos = $this->player->getLocation()->asVector3();
			$packet->x = $pos->x;
			$packet->y = $pos->y + $this->player->getEyeHeight();
			$packet->z = $pos->z;
			$this->player->getNetworkSession()->sendDataPacket($packet);
			unset($packet, $pos, $note);
		}
	}
}