<?php

namespace HouseRental;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\math\Vector3 as Vector3;
use pocketmine\level\Level;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\BlockBreakEvent;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\ComnandSender;

class Main extends PluginBase{

public function onEnable(){

	$this->saveDefaultConfig();
	$this->reloadConfig();
	$this->v = "1.0";
	$this->crt = "artide";
	$this->getLogger()->info("Plugin loaded successfully!");
	$this->getLogger()->info("version ".$this->v." by ".$this->crt);
	$this->cost = EconomyAPI::getInstance();

 }

public function onInteract(PlayerInteractEvent $event){
   $p = $event->getPlayer();

	if($blockID == 63 || $blockID == 68 || $blockID == 323){
		
	$tile = $event->getBlock()->getLevel()->getTile();
	if($tile instanceof Sign){
	$text = $tile->getText();
	$tile->setText($this->getConfig()->get("Occupied-text-1"), $this->getConfig()->get("Occupied-text-2"), $this->getConfig()->get("Occupied-text-3"), $this->getConfig()->get("Occupied-text-4"));
	$pn = str_replace("@player", $p->getName(), $pn);
	$this->home = new Config($this->path."playerhomes/".$p->getName().".yml", Config::YAML);
	
	$x = $p->getFloorX();
	$y = $p->getFloorY();
	$z = $p->getFloorZ();
	$this->home->set("x", $x);
	$this->home->set("y", $y);
	$this->home->set("z", $z);
	$this->home->save();
	if($this->cost->p->getAllMoney() === $this->getConfig()->get("Minimun-cost")){
	$this->getServer()->broadcast($p->getName." rented ".$text[0]);
	$this->cost->reduceMoney($p, 
	$this->getConfig()->get("House-rent-cost"));
	
	}elseif($this->cost->p->getAllMoney() !== $this->getConfig()->get("Minimun-cost")){
	$p->sendMessage($this->getConfig()->get("Not-enough-money"));
	 }
   }
  }
 }
public function onCommand(CommandSender $sender, Command $command, $label, array $args) {

	$cmd = strtolower($command->getName());
	
	switch($cmd){
	case "home":
	if($sender->hasPermission("taprent.command.home")){
	if(isset($this->home->get("x") && $this->home->get("y") && $this->home->get("y"))){
	$p->teleport(new Vector3($this->home->get("x"), $this->home->get("y"), $this->home->get("z")));
		
	$p->sendMessage("You have been telported to your home.");
	
	   }
	 }
	}
 }

public function onBreak(BlockBreakEvent $event){
	$p = $event->getPlayer();
	
	$tile = $event->getBlock()->getLevel()->getTile();
	if($tile instanceof Sign){
	$text = $tile->getText();
	
	$this->home->set("x", 0);
	$this->home->set("y", 0);
	$this->home->set("z", 0);
	$this->home->save();
	$tile->setText($this->getConfig()->get("Disoccupied-text-1"), $this->getConfig()->get("Disoccupied-text-2"), $this->getConfig()->get("Disoccupied-text-3"), $this->getConfig()->get("Disoccupied-text-4"));

	$this->getServer()->broadcast($p->getName()." disoccupied a home.");
	$p->sendMessage("You must pay rent to stay here again.");
	
	}
 }

public function onDisable(){
  $this->getLogger()->info("Plugin unloaded!");

 }

}
?>
