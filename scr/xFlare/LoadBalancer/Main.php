<?php
namespace xFlare\LoadBalancer;

use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\Server;

class Main extends PluginBase implements Listener{
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->getLogger()->info(TextFormat::GREEN."> Loading plugin, checking config...");
        $config = $this->getConfig();
        if($config->get("enable") === true){
            $this->getLogger()->info(TextFormat::RED."- You must enable the plugin by turning "enable" to true in config.yml");
            $this->disablePlugin();
        }
        else{
            $this->getLogger()->info(TextFormat::GREEN."- Plugin loaded. Calculating data...");
            $this->startPlugin($config);
        }
    }
    public fuction startPlugin($config){
        if($config->get("version") === 1.0.0){
            $this->switchServer();
        }
        else{
             $this->getLogger()->info(TextFormat::RED."- Incorrect plugin verion. Disableing plugin...");
             $this->disablePlugin();
        }
    }
    public function switchServer(){
        foreach()
    }
