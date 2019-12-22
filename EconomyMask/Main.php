<?php

declare(strict_types=1);

namespace MMask;

use pocketmine\plugin\PluginBase;
use MMask\task\EffectTask;
use pocketmine\Player; 
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

use jojoe77777\FormApi;
use pocketmine\lang\BaseLang;
use onebone\economyapi\EconomyAPI;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerMoveEvent;

class Main extends PluginBase implements Listener {
    
    /** @var Main $instance */
    private static $instance;
	
	public $plugin;

	public function onEnable() : void{
	    self::$instance = $this;
	    $this->getScheduler()->scheduleRepeatingTask(new EffectTask(), 20);
        $this->getLogger()->info(TextFormat::GREEN . "MMask Enable");
        $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");	
        @mkdir($this->getDataFolder());
    $this->saveDefaultConfig();
    $this->getResource("config.yml");
	}
	
	public static function getInstance() : self{
	    return self::$instance;
	}
	
	public function onCommand(CommandSender $sender, Command $command, String $label, array $args) : bool {
        switch($command->getName()){
            case "mmask":
            $this->FormSell($sender);
            return true;
        }
        return true;
	}
	
	 public function FormSell($sender){
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function(Player $sender, $data){
          $result = $data;
          if($result === null){
          }
          switch($result){
              case 0:
              break;
              case 1:
                  $money = $this->eco->myMoney($sender);                                      $normal = $this->getConfig()->get("price.normal");
									if($money >= $normal){		                               $this->api->ReduceMoney($sender, $normal);
                  $sender->getInventory()->addItem(Item::get(397, 0, 1));   
                  $sender->sendMessage("§aSelected Normal Mask");
                                      return true;
                                    }else{
                                                         $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                                    }
			  break;
              case 2:
                  $money = $this->eco->myMoney($sender);                                      $healer = $this->getConfig()->get("price.healer");
									if($money >= $healer){
				  $this->api->ReduceMoney($sender, $healer);
                  $sender->getInventory()->addItem(Item::get(397, 3, 1));   
                  $sender->sendMessage("§aSelected Healer Mask");
                                      return true;
                                    }else{
                                                         $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                                    }
              break;
              case 3:
                  $money = $this->eco->myMoney($sender);                                      $infection = $this->getConfig()->get("price.infection");
									if($money >= $infection){		                           $this->api->ReduceMoney($sender, $infection);
                  $sender->getInventory()->addItem(Item::get(397, 2, 1));   
                  $sender->sendMessage("§aSelected Infection Mask");
                                      return true;
                                    }else{
                                                         $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                                    }
              break;
              case 4:
                  $money = $this->eco->myMoney($sender);                                      $protector = $this->getConfig()->get("price.protector");
									if($money >= $protector){		                               $this->api->ReduceMoney($sender, $protector);
                  $sender->getInventory()->addItem(Item::get(397, 4, 1));   
                  $sender->sendMessage("§aSelected Protector Mask");
                                      return true;
                                    }else{
                                                         $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                                    }
              break;
              case 5:
                  $money = $this->eco->myMoney($sender);                                      $hercules = $this->getConfig()->get("price.hercules");
									if($money >= $hercules){		                               $this->api->ReduceMoney($sender, $hercules);
                  $sender->getInventory()->addItem(Item::get(397, 1, 1));   
                  $sender->sendMessage("§aSelected Hercules Mask");
                                      return true;
                                    }else{
                                                         $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                                    }
			  break;
			  case 6:
			      $money = $this->eco->myMoney($sender);                                      $dragon = $this->getConfig()->get("price.dragon");
									if($money >= $dragon){		                               $this->api->ReduceMoney($sender, $dragon);
                  $sender->getInventory()->addItem(Item::get(397, 5, 1));   
                  $sender->sendMessage("§aSelected DragonSlayer Mask");
                                      return true;
                                    }else{
                                                         $sender->sendMessage($this->getConfig()->get("msg.no-money"));
                                    }
          }
        });
        $balance = $this->eco->myMoney($sender);
        $name = $this->getName($sender);
		$normal = $this->getConfig()->get("price.normal");
		$healer = $this->getConfig()->get("price.healer");
		$infection = $this->getConfig()->get("price.infection");
		$protector = $this->getConfig()->get("price.protector");
		$hercules = $this->getConfig()->get("price.hercules");
		$dragon = $this->getConfig()->get("price.dragon");
					
        $form->setTitle("§l§6M§eMask §bMenu");
        $form->setContent("§aYou have §c$.{$balance} \n§r§bchoose button to buy mask with your money");
        $form->addButton("§c§lExit\n§rTap To Exit");
        $form->addButton("§l§fNormal §6Mask : §e$".$normal, 1,"https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/9/9c/Skeleton_Skull.png/150px-Skeleton_Skull.png?version=a8e363e391d635a40fa55faa784562f8");
		$form->addButton("§l§cHealer §6Mask : §e$".$healer, 1,"https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/1/13/Player_Head.png/150px-Player_Head.png?version=42ad44591291f911036dfe53ba7d9f77");
		$form->addButton("§l§3Infection §6Mask : §e$".$infection, 1,"https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/f/f8/Zombie_Head.png/150px-Zombie_Head.png?version=8a15fc74edd30aa4d804eb08247859a7");
		$form->addButton("§l§bProtector §6Mask : §e$".$protector, 1,"https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/9/97/Creeper_Head.png/150px-Creeper_Head.png?version=94a13fb9d962554106e25c5a777fc9fd");
		$form->addButton("§l§bHercules §6Mask : §e$".$hercules, 1,"https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/a/ac/Wither_Skeleton_Skull.png/150px-Wither_Skeleton_Skull.png?version=72391cd2dd387f87838d8e5af634a22f");
		$form->addButton("§l§dDragon§cSlayer §6Mask : §e$".$dragon, 1,"https://gamepedia.cursecdn.com/minecraft_gamepedia/thumb/b/b6/Dragon_Head.png/150px-Dragon_Head.png?version=0687499d687de1761e5c0319c0ef6e86");
        $form->sendToPlayer($sender);
	}
}