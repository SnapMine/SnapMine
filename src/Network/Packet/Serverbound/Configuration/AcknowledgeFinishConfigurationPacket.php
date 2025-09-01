<?php

namespace SnapMine\Network\Packet\Serverbound\Configuration;

use SnapMine\Manager\ChunkManager\ChunkRequest;
use SnapMine\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use SnapMine\Network\Packet\Clientbound\Play\GameEventPacket;
use SnapMine\Network\Packet\Clientbound\Play\JoinGamePacket;
use SnapMine\Network\Packet\Clientbound\Play\SetCenterChunk;
use SnapMine\Network\Packet\Clientbound\Play\SetDefaultSpawnPositionPacket;
use SnapMine\Network\Packet\Clientbound\Play\SynchronizePlayerPositionPacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\ServerState;
use SnapMine\Session\Session;
use React\EventLoop\Loop;
use function React\Async\async;

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

        // Load and send the center chunk lazily via ChunkManager
        $world = $player->getServer()->getWorld("world");
        $callback = function ($chunk) use ($player) {
            if ($chunk !== null) {
                $player->sendPacket(new ChunkDataAndUpdateLightPacket($chunk));
            }
        };

        $session->sendPacket(new SetDefaultSpawnPositionPacket());

        $session->sendPacket(
            new GameEventPacket(13, 0.0)
        );
        $session->sendPacket(
            new SetCenterChunk()
        );

        $cm = $player->getServer()->getChunkManager();
        Loop::addTimer(0.1, async(function () use ($world, $callback, $cm) {
            $cm->loadRadius($world, 0, 0, 15, $callback);
        }));
        $cm->addToQueue(new ChunkRequest($world, 0, 0, $callback));

        $player->sendPacket(new SynchronizePlayerPositionPacket($player, 0, 0, 0));

        var_dump(microtime(true) - $time);
    }
}
