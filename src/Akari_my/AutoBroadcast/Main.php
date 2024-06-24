<?php

namespace Akari_my\AutoBroadcast;

use Akari_my\AutoBroadcast\Task\BroadcastTask;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

    private $messages = [];
    private $interval = 120;
    private $currentIndex = 0;
    private $prefix = "";

    protected function onEnable(): void{
        $this->saveDefaultConfig();
        $this->messages = $this->getConfig()->get("broadcast-message", []);
        $this->interval = $this->getConfig()->get("internal", 120);
        $this->prefix = $this->getConfig()->get("prefix", "§8[§eAuto§cBroadcast§8] §8»§r");

        if (!empty($this->messages)){
            $this->getScheduler()->scheduleDelayedRepeatingTask(new BroadcastTask($this), $this->interval * 20, $this->interval * 20);
        }
    }

    public function getNextMessage(): string {
        if (empty($this->messages)) {
            return "";
        }

        $message = $this->messages[$this->currentIndex];
        $this->currentIndex = ($this->currentIndex + 1) % count($this->messages);

        return $this->prefix . " " . $message;
    }

    /*
     * TODO: commands coming soon...
    private function registerCommands(){

    }*/
}