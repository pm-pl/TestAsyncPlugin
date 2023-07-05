<?php

namespace vennv\TestAsync;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\ClosureTask;
use vennv\Async;
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
        new Async(function() use ($player) {
			
            $url = "https://www.google.com";
            
			$response = Async::await(function() use ($url) {
                return file_get_contents($url);
            });

            var_dump($response);
        });
    }

}