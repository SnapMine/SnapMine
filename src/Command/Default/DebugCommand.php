<?php

use SnapMine\Artisan;
use SnapMine\Command\Command;
use SnapMine\Command\Nodes\CommandNode;
use SnapMine\Entity\Player;

$baseCmd = Command::new('debug', function (Player $player) {
    $player->sendMessage("\n-------------- [GENERAL DEBUG INFO] -------------- \nSnapMine by SnapMine Contributors");
    $player->sendMessage(" - Running version " . Artisan::getVersion());
    $player->sendMessage("\n - Memory Usage: " . round(memory_get_usage() / 1024 / 1024, 2) . " MB");
    $player->sendMessage(" - Uptime: " . getrusage()['ru_utime.tv_sec'] . " seconds");
});

$baseCmd->literal("chunk", function (Player $player) {
    $world = $player->getWorld();
    $location = $player->getLocation();
    $chunk = $world->getChunkFromPosition($location);
    $section = $chunk->getSection((int)$location->getY());

    $loadedChunks = 0;
    foreach($player->getServer()->getWorlds() as $w) {
        $loadedChunks += count($w->getLoadedChunks());
    }

    $player->sendMessage("\n-------------- [CHUNK DEBUG INFO] -------------- \n");
    $player->sendMessage("Server:");
    $player->sendMessage(" - Chunks loaded : " . $loadedChunks);

    $player->sendMessage("\nThis chunk:");
    $player->sendMessage(" - World: " . $world->getName());
    $player->sendMessage(" - Chunk: (" . $chunk->getX() . ", " . $chunk->getZ() . ")");
    if($section !== null) {
        $player->sendMessage(" - Chunk Section Y: " . $section->getY());
    } else {
        $player->sendMessage(" - No chunk section found at your Y level.");
    }


})
    ->group(function (CommandNode $group) {
        $group->literal("palette_usage", function (Player $player) {
            $world = $player->getWorld();
            $location = $player->getLocation();
            $chunk = $world->getChunkFromPosition($location);
            $section = $chunk->getSection((int)$location->getY());

            if($section === null) {
                $player->sendMessage("No chunk section found at your Y level.");
                return;
            }

            $palette = $section->getPalettedContainer()->getPalette();
            $player->sendMessage("Palette usage for chunk section at Y: " . $section->getY() . " in chunk (" . $chunk->getX() . ", " . $chunk->getZ() . "):");
            $player->sendMessage(" - BPE: " . $section->getPalettedContainer()->getBitsPerEntry());

            /** @var \SnapMine\Block\Data\BlockData $blockData */
            foreach($palette as $blockData) {
                $player->sendMessage(" - " . $blockData->getMaterial()->getKey() . "(state id: " . $blockData->computedId() . ") - Count: " . $section->getPalettedContainer()->getNumberOf($blockData));

            }
        });
    });

$baseCmd->build();