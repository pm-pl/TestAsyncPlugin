<?php

namespace vennv\TestAsync;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\ClosureTask;
use vennv\System;

final class TestAsync extends PluginBase implements Listener {

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(
            function() : void {
                System::endMultiJobs();
            }
        ), 20);
    }
	
	public function onBreak(BlockBreakEvent $event) : void {
        $player = $event->getPlayer();
		
		$url = "https://www.google.com";
		
        $fecth = System::fetchJg($url);
		$fecth->then(function($value) {
			var_dump($value);
		});
		$fecth->catch(function($reason) {
			var_dump($reason);
		});
    }

}