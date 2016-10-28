<?php

namespace grapplinghook;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerFishEvent;
use pocketmine\event\player\PlayerEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginManager;
use pocketmine\Server;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\utils\Config;

class GrapplingHook extends PluginBase implements Listener{
       /*
	double hookThreshold;
	double hForceMult;
	double hForceMax;
	double vForceMult;
	double vForceBonus;
	double vForceMax;
	*/
	@Override
    public function onEnable(){
	$this->getserver()->getPluginManager()->registerEvents($this,$this);
	    @mkdir($this->getDataFolder());
	    	$this->start= new Config($this->getDataFolder()."Config.yml", Config::YMAL, array());
		$config = getConfig();
		$hookThreshold = config->getDouble("hook-threshold");
		$hForceMult = config->getDouble("horizontal-force-mult");
		$hForceMax = config->getDouble("horizontal-force-max");
		$vForceMult = config->getDouble("vertical-force-mult");
		$vForceBonus = config->getDouble("vertical-force-bonus");
		$vForceMax = config->getDouble("vertical-force-max");
		$this->saveDefaultConfig();
	    		$this->getLogger()->info(TEXTFORMAT::GOLD . "§cTSR.TW§e星童插件組 §6GrapplingHook 飛天鉤加載中");
	}
    public function onDisable(){
        $this->getLogger()->info(TEXTFORMAT::RED . "GrapplingHook 飛天鉤卸載");
    }
    
    public function onPlayerFish(PlayerFishEvent event){
	       /*
	        Vector = vector3;
		Entity = entity;
		Block = block;
		Player = player;
		double = d;
	       */
	        if (event->getState()->equals(PlayerFishEvent::State_IN_GROUND) || event->getState()->equals->(PlayerFishEvent::State_FAILED_ATTEMPT)) {
			$entity = event->getHook();
			$block = entity->getWorld()->getBlockAt(entity->getLocation()->add(0.0, -hookThreshold, 0.0));
			
			if (!block->isEmpty() && !block->isLiquid()) {
				$player = event->getPlayer();
				
				$vector3 = entity->getLocation()->subtract(player->getLocation())->toVector();
				
				if ($vector3->getY() < 0.0)
					$vector3->setY(0.0);
				
				$vector3->setX($vector3->getX() * hForceMult);
				$vector3->setY($vector3->getY() * vForceMult + vForceBonus);
				$vector3->setZ($vector3->getZ() * hForceMult);
				
				d = hForceMax * hForceMax;
				if (vector3->clone()->setY(0.0)->lengthSquared() > d) {
					d = d / vector3->lengthSquared();
					$vector3->setX($vector3->getX() * d);
					$vector3->setZ($vector3->getZ() * d);
				}
				
				if ($vector3->getY()->vForceMax)
					$vector3->setY(vForceMax);
				
				player->setVelocity($vector3);
			}
		}
	}

}

		  
