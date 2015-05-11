<?php


//Classes


//onEnable
$event->getPlayer()->sendMessage("> This server uses LoadBalancer by xFlare");
$event->getPlayer()->sendMessage("> You may get redirected to another server.");
$config = $this->getConfig();
$number = $config->get("number");

$random_server = rand(0, $number);
