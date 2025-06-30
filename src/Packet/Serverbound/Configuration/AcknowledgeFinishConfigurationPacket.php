<?php

namespace Nirbose\PhpMcServ\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Entity\GameProfile;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Event\EventManager;
use Nirbose\PhpMcServ\Event\PlayerJoinEvent;
use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\GameEventPacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\JoinGamePacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\PlayerAbilitiesPacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\SetCenterChunk;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\SetDefaultSpawnPositionPacket;
use Nirbose\PhpMcServ\Packet\Clientbound\Play\SynchronizePlayerPositionPacket;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;

class AcknowledgeFinishConfigurationPacket extends Packet
{
    public function getId(): int
    {
        return 0x03;
    }

    public function read(PacketSerializer $in, string $buffer, int &$offset): void
    {
        // No data to read for this packet
    }

    public function write(PacketSerializer $out): void
    {
        // No data to write for this packet
    }

    public function handle(Session $session): void
    {
        $session->setState(ServerState::PLAY);

        EventManager::call(
            new PlayerJoinEvent(
                new Player($session, new GameProfile("test", UUID::generate()))
            )
        );

        $session->sendPacket(new JoinGamePacket());
        $session->sendPacket(
            new PlayerAbilitiesPacket()
        );
        $session->sendPacket(new SetDefaultSpawnPositionPacket());
        $session->sendPacket(new SynchronizePlayerPositionPacket(
            random_int(1, 1000000),
            0.0, // x
            64.0, // y
            0.0, // z
            0.0, // velocityX
            0.0, // velocityY
            0.0, // velocityZ
            0.0, // yaw
            0.0, // pitch
        ));
        $session->sendPacket(
            new GameEventPacket(13, 0.0)
        );
        $session->sendPacket(
            new SetCenterChunk()
        );
        for ($i = 0; $i < 16; $i++) {
            for ($j = 0; $j < 16; $j++) {
                $session->sendPacket(
                    new ChunkDataAndUpdateLightPacket($i, $j)
                );
            }
        }
    }
}