<?php

namespace CustomTag;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase{
	
	public function onEnable(){
	$this->saveDefaultConfig();
	$this->reloadConfig();
	$this->getLogger()->info("Everything loaded!");
	
	}
	
	public function onJoin(PlayerJoinEvent $event){
	
	$p = $event->getPlayer();
   
	$format = str_replace("@player", $p->getName(), $format);
	$p->setNameTag($this->getConfig()->get("Name-tag-format"), $format);
}
	
	public function onDisable(){
	
	$this->getLogger()->info("Plugin unloaded!");
	
	}
	
}
