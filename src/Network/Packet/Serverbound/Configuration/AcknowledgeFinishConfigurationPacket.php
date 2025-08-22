<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\GameEventPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\JoinGamePacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\PlayerAbilitiesPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SetCenterChunk;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SetDefaultSpawnPositionPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SynchronizePlayerPositionPacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Session\Session;

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
        $session->setState(ServerState::PLAY);

        $player = $session->getPlayer();

        $session->sendPacket(new JoinGamePacket($player));
        $session->sendPacket(new SetDefaultSpawnPositionPacket());
        $session->sendPacket(new SynchronizePlayerPositionPacket(
            $player,
            0.0,
            0.0,
            0.0,
        ));
        $session->sendPacket(
            new GameEventPacket(13, 0.0)
        );
        $session->sendPacket(
            new SetCenterChunk()
        );
        $session->sendPacket(
            new ChunkDataAndUpdateLightPacket(0, 0)
        );

        for ($i = -5; $i < 5; $i++) {
            for ($j = -5; $j < 5; $j++) {
                if ($j == 0 && $i == 0) {
                    continue;
                }
                if ($session->getServer()->getWorld("world")->getChunk($i, $j) === null) {
                    continue;
                }

                $session->sendPacket(
                    new ChunkDataAndUpdateLightPacket($i, $j)
                );
            }

        }
    }
}