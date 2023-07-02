<?php

namespace vennv\TestAsync;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\ClosureTask;
use vennv\Async;
use vennv\System;

System::start();

final class TestAsync extends PluginBase implements Listener {

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(
            function() : void {
                System::endNonBlocking();
            }
        ), 20);
    }

    public function onBreak(BlockBreakEvent $event) : void {
        $player = $event->getPlayer();
        new Async(function() use ($player) {
            $url = "https://www.google.com";
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);

            if (!$response) {
                $error = curl_error($curl);
                curl_close($curl);
                $player->sendMessage($error);
            }

            curl_close($curl);

            $player->sendMessage($response);
        });
    }

}