<?php

namespace KillCheck;

use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\server;
use pocketmine\level;
use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\math\Vector3;
use onebone\economyapi\EconomyAPI;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

	class Main extends PluginBase implements Listener
		
	{
		
		public function onEnable(){
			$this->saveDefaultConfig();
			$this->reloadConfig();
			$v = "0.1";
			$c = "Artide";
			$this->getServer()->getPluginManager()->registerEvents($this,$this);
			$this->player = EconomyAPI::getInstance();
			$this->getLogger()->info("Plugin loaded! v_".$v." By ".$c);
	}
	
		public function onPlayerDeathEvent(PlayerDeathEvent $event){
			$player = $event->getEntity();
			$name = strtolower($player->getName());
			if($player instanceof Player){
				$cause = $player->getLastDamageCause();
				if($cause instanceof EntityDamageByEntityEvent){
					$killer = $cause->getDamager();
					if($killer instanceof Player){
						$killer->sendMessage($this->getConfig()->get("Killer-Message"));
						  $this->player->addMoney($killer, $this->getConfig()->get("Added-Coins"));
						    $player->sendMessage($this->getConfig()->get("Player-Message"));
				 
      }
       
    }
		
  }
	
}
		
		public function onDisable(){
			$this->getLogger()->info("Plugin unloaded!");
		}
		
}
?>
