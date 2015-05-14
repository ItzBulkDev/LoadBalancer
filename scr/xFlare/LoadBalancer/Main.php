<?php
namespace xFlare\LoadBalancer;

use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\Server;

class Main extends PluginBase implements Listener{
    public function onEnable(){
        $this->saveDefaultConfig();
        $config = $this->getConfig();
        $random_server = rand(0, $number);
    }
}
