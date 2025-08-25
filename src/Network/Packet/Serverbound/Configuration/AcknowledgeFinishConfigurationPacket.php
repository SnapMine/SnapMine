<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Manager\ChunkManager\ChunkRequest;
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
            $cm->loadRadius($world, 0, 0, 20, $callback);
        }));
        $cm->addToQueue(new ChunkRequest($world, 0, 0, $callback));

        $player->sendPacket(new SynchronizePlayerPositionPacket($player, 0, 0, 0));

        var_dump(microtime(true) - $time);
    }
}
