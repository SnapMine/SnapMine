<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Configuration;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\AddEntityPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\ChunkDataAndUpdateLightPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\GameEventPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\JoinGamePacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\PlayerAbilitiesPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\PlayerInfoUpdatePacket;
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
        // No data to read for this packet
    }

    public function write(PacketSerializer $out): void
    {
        // No data to write for this packet
    }

    public function handle(Session $session): void
    {
        $session->setState(ServerState::PLAY);

        $player = $session->getPlayer();

        $session->sendPacket(new JoinGamePacket($player));
        $session->sendPacket(new PlayerAbilitiesPacket());
        $session->sendPacket(new SetDefaultSpawnPositionPacket());
        $session->sendPacket(new SynchronizePlayerPositionPacket(
            random_int(1, 1000000),
            $player,
            0.0, // x
            0.0, // y
            0.0, // z
            0.0, // velocityX
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

        $this->testLoadAllPlayer($player); // TODO: Change this code
    }

    private function testLoadAllPlayer(Player $newPlayer) {
        $infos = [];

        /** @var Player $player */
        foreach (Artisan::getPlayers() as $player) {
            if ($newPlayer->getUuid() === $player->getUuid()) {
                continue;
            }

            $infos[$player->getUuid()->toString()] = [
                [
                    'name' => $player->getName(),
                ]
            ];
        }

        $newPlayer->sendPacket(new PlayerInfoUpdatePacket(0x01, $infos));

        /** @var Player $player */
        // TODO: Change this code
        foreach (Artisan::getPlayers() as $player) {
            if ($newPlayer->getUuid() === $player->getUuid()) {
                continue;
            }

            $packet = new AddEntityPacket(
                $player,
                0,
                0,
                0,
                0,
                0,
            );

            $newPlayer->sendPacket($packet);
        }
    }
}