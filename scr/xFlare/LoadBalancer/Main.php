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
    public function switchServer(){
        $this->getLogger()->info(TextFormat::RED."> Switching the redirect server...");
        $server_number = 0;
        foreach($this->getConfig->get("Servers") as $server){
            if($server !== false){
                $server_number++;
            }
        }
        $set_server = rand(0, $server_number);
        if($set_server === 0){
            $myserver = $this->getConfig()->get("Servers");
            $myserver = $myserver[0];
            $this->getLogger()->info(TextFormat::GREEN."- Server set to: $myserver");
        }
    }
    public function disablePlugin(){
        $this->getLogger()->info(TextFormat::RED."- Disabling plugin...");
        $this->getConfig()->set("enabled", false);
        $this->getConfig()->save();
    }
}
