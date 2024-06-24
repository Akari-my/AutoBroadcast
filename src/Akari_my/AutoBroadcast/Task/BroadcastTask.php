<?php

namespace Akari_my\AutoBroadcast\Task;

use Akari_my\AutoBroadcast\Main;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class BroadcastTask extends Task{

    private Main $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function onRun(): void {
        $message = $this->plugin->getNextMessage();
        if ($message !== "") {
            Server::getInstance()->broadcastMessage($message);
        }
    }
}