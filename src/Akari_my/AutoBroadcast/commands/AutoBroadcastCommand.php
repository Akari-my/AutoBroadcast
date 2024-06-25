<?php

namespace Akari_my\AutoBroadcast\commands;

use Akari_my\AutoBroadcast\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\Server;

class AutoBroadcastCommand extends Command implements PluginOwned {

    protected Main $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        parent::__construct("broadcast", "Send a broadcast message");
        $this->setPermission("autobroadcast.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if (!$sender->hasPermission("autobroadcast.use")){
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['no_permission']);
            return false;
        }

        if (count($args) < 1){
            $sender->sendMessage($this->plugin->getConfig()->get('messages')['usage']);
            return false;
        }

        $message = implode(" ", $args);
        $fullMessage = $this->plugin->prefix . " " . $message;

        Server::getInstance()->broadcastMessage($fullMessage);
        return true;
    }

    public function getOwningPlugin(): Plugin{
        return $this->plugin;
    }
}