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
            $this->getLogger()->info(TextFormat::RED."- You must enable the plugin by turning \"enable\" to true in config.yml");
            $this->disablePlugin();
        }
        else{
            $this->getLogger()->info(TextFormat::GREEN."- Plugin loaded. Calculating data...");
            $this->startPlugin($config);
        }
    }
    public function startPlugin($config){
        if($config->get("version") === 1.0.0){
            $this->switchServer();
        }
        else{
             $this->getLogger()->info(TextFormat::RED."- Invalid plugin version. Disabling plugin...");
             $this->disablePlugin();
        }
    }
    public function onPlayerJoin(PlayerJoinEvent $event){
        $send_to = $this->getConfig()->get("current-server");\
        $check = $this->getConfig()->get("This-Server-IP");
        if($check !== $send_to){
            $event->getPlayer()->sendMessage("- Welcome! Please wait..Redirecting...");
   //         $this->getServer()->dispatchCommand("");
        }
    }
    public function switchServer(){
        $this->getLogger()->info(TextFormat::RED."> Switching the redirect server...");
        $number = count($this->getConfig->getNested()->get("Servers"));
        $set_server = mt_rand(0, $number);
        $switch_to = $this->getConfig()->get("Servers")[$set_server];
        $this->getLogger()->info(TextFormat::RED."- Server redirect set to: $switch_to");
    }
    public function disablePlugin(){
        $this->getLogger()->info(TextFormat::RED."- Disabling plugin...");
        $this->getConfig()->set("enabled", false);
        $this->getConfig()->save();
    }
}
