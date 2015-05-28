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
        $files = $this->getServer()->getPluginManager();
        if(!($files->getPlugin("FastTransfer") !== true){
            $this->getLogger()->info(TextFormat::RED."- You must install the plugin FastTransfer!");
            $this->getLogger()->info(TextFormat::GREEN."- If you have Pundler do /get and we will send a command to download FastTranser for you.");
            $this->getLogger()->info(TextFormat::GREEN."- Otherwise download FastTransfer here: https://github.com/shoghicp/FastTransfer/releases");
            return true;
        }
        
        if($config->get("enabled") !== true){
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
        $send_to = $this->getConfig()->get("current-server");
        $check = $this->getConfig()->get("this-server-ip-address");
        //Define port...
        if($check !== $send_to){
            $player = $event->getPlayer();
            $event->getPlayer()->sendMessage($this->getConfig()->get("redirect"));
            $this->getServer()->dispatchCommand($event->getPlayer(), "transfer $player $send_to $port");
            $this->getServer()->getScheduler()->scheduleDelayedTask(new CallBackTask([$this, "ErrorCheck"], [$player]), 60);
        }
    }
    public function switchServer(){
        $this->getLogger()->info(TextFormat::RED."> Switching the redirect server...");
        $number = count($this->getConfig->getNested()->get("Servers")) - 1;
        if($number < 0){
            $number = 0;
        }
        $set_server = mt_rand(0, $number);
        $switch_to = $this->getConfig()->get("Servers")[$set_server];
        $this->getLogger()->info(TextFormat::RED."- Server redirect set to: $switch_to");
    }
    public function disablePlugin(){
        $this->getLogger()->info(TextFormat::RED."- Disabling plugin...");
        $this->getConfig()->set("enabled", false);
        $this->getConfig()->save();
    }
    public function ErrorCheck($player){
        if($player !== null){
            $player->sendMessage($this->getConfig()->get("error")); //If the player to not transfered in time
        }
    }
}
