<?php

declare(strict_types=1);

namespace Ronay1140\RulesUI;

/*
 *
 * Info Plugin
 * Dibuat oleh Ronay1140
 *
 */

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

class Main extends PluginBase implements Listener {
 
   public function onEnable() {
        $this->getLogger()->info(C::GREEN . "Enable!");
        
        @mkdir($this->getDataFolder());
        
        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
   }
 
   public function onDisable() {
        $this->getLogger()->info(C::RED . "Disable!");
   }
 
   public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()) {
            case "rulesui":
                if($sender instanceof Player) {
                   $this->RulesUI($sender);
                } else {
                   $sender->sendMessage($this->cfg->getNested("messages.use_in_game"));
                   return true;
                }
                return true;
            }
        return true;
   }
   
   public function RulesUI($sender) { 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null) {
                return true;
            }             
            switch($result) {
                case 0:
                    $sender->sendMessage($this->cfg->getNested("messages.close_plugin"));
                break;
       
            }
       });
       $form->setTitle($this->cfg->getNested("menu.title"));
       $form->setContent($this->cfg->getNested("menu.description"));
       $form->addButton($this->cfg->getNested("btn.close"));
       $form->sendToPlayer($sender);
       return $form;
   }
 
}
