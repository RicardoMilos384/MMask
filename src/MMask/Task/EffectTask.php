<?php

declare(strict_types=1);

namespace EffectTask\task;

use MMask\Main;
use pocketmine\item\Item;
use pocketmine\scheduler\Task;
use pocketmine\entity\Effect;
use pocketmine\utils\config;
use pocketmine\entity\EffectInstance;

class EffectTask extends Task {
    
    public function onRun(int $tick) : void{
        foreach(Main::getInstance()->getServer()->getOnlinePlayers() as $players){
            $inv = $players->getArmorInventory();
            $helmet = $inv->getHelmet();
            if(!$helmet->getId() === Item::MOB_HEAD) return;
            switch($helmet->getDamage()){
                case 2:
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::$this->getConfig()->get("effect-1")), 30, 2, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::$this->getConfig()->get("effect-2")), 30, 1, false));
                    return;
                case 1:
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::HEALTH_BOOST), 30, 2, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::REGENERATION), 30, 2, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP_BOOST), 30, 2, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::FIRE_RESISTANCE), 30, 3, false));
                    return;
                case 3:
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::REGENERATION), 30, 3, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::SATURATION), 30, 3, false));
                    return;
                case 4:
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::STRENGTH), 30, 2, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::ABSORPTION), 30, 2, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::RESISTANCE), 30, 3, false));
                    return;
                case 5:
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::FIRE_RESISTANCE), 20, 4, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP_BOOST), 20, 3, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::HEALTH_BOOST), 20, 5, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20, 3, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::NIGHT_VISION), 20, 3, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::ABSORPTION), 20, 3, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20, 3, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::SATURATION), 20, 3, false));
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::REGENERATION), 20, 3, false));
                    return;
            }
        }
    }
}
