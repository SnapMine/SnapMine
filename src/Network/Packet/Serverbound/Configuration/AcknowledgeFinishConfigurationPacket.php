<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\GameEventPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\JoinGamePacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SetCenterChunk;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SetDefaultSpawnPositionPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SynchronizePlayerPositionPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Session\Session;
use function React\Async\async;
use function React\Promise\all;

class AcknowledgeFinishConfigurationPacket extends ServerboundPacket
{
    public function getId(): int
    {
        return 0x03;
    }

    public function read(PacketSerializer $serializer): void
    {
    }

    public function handle(Session $session): void
    {
        $time = microtime(true);
        $session->setState(ServerState::PLAY);

        $player = $session->getPlayer();

        $session->sendPacket(new JoinGamePacket($player));
        $session->sendPacket(new SetDefaultSpawnPositionPacket());
        $session->sendPacket(
            new GameEventPacket(13, 0.0)
        );
        $session->sendPacket(
            new SetCenterChunk()
        );

        $player->sendPacket(new ChunkDataAndUpdateLightPacket($player->getServer()->getWorld("world")->getChunk(0, 0)));


        $promises = [];

        for ($i = -5; $i < 5; $i++) {
                for ($j = -5; $j < 5; $j++) {
                    if ($j == 0 && $i == 0) {
                        continue;
                    }

                    $promises[] = async(function () use ($player, $i, $j) {

                        $chunk = $player->getServer()->getWorld("world")->getChunk($i, $j);
                        $player->sendPacket(new ChunkDataAndUpdateLightPacket($chunk));
                    })();
                }
        }

        all($promises)->finally(function () {
            echo memory_get_usage() . "\n";
        });


        $player->sendPacket(new SynchronizePlayerPositionPacket($player, 0.0, 0.0, 0.0));
        /*
        for ($i = -8; $i < 8; $i++) {
            for ($j = -8; $j < 8; $j++) {
                if ($j == 0 && $i == 0) {
                    continue;
                }

                $chunk = $player->getServer()->getWorld("world")->getChunk($i, $j);
                $player->sendPacket(new ChunkDataAndUpdateLightPacket($chunk));
            }
        }
        */



        var_dump(microtime(true) - $time);
    }
}