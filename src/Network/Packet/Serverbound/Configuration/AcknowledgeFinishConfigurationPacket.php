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
        $session->sendPacket(new PlayerAbilitiesPacket());
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
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($session->getServer()->getRegion()->getChunk($i, $j) === null) {
                    continue;
                }

                $session->sendPacket(
                    new ChunkDataAndUpdateLightPacket($i, $j)
                );
            }

        }
    }
}