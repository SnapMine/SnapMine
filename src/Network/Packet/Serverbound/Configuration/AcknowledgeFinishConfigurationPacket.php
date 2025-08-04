<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\GameEventPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\JoinGamePacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\PlayerAbilitiesPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SetCenterChunk;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SetDefaultSpawnPositionPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\SynchronizePlayerPositionPacket;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Session\Session;

class AcknowledgeFinishConfigurationPacket extends Packet
{
    public function getId(): int
    {
        return 0x03;
    }

    public function read(PacketSerializer $in, string $buffer, int &$offset): void
    {
    }

    public function write(PacketSerializer $out): void
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
        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 2; $j++) {
                $session->sendPacket(
                    new ChunkDataAndUpdateLightPacket($i, $j)
                );
            }

        }
    }
}