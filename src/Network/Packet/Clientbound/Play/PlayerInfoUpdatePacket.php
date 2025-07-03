<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;

class PlayerInfoUpdatePacket extends Packet
{
    public const ADD_PLAYER = 0x01;
    public const INITIALIZE_CHAT = 0x02;
    public const UPDATE_GAMEMODE = 0x04;
    public const UPDATE_LISTED = 0x08;
    public const UPDATE_LATENCY = 0x10;
    public const UPDATE_DISPLAY_NAME = 0x20;
    public const UPDATE_LIST_PRIORITY = 0x40;
    public const UPDATE_HAT = 0x80;

    /**
     * @param int $actionMask
     * @param array<string, array<int, array<string, mixed>>> $players
     */
    public function __construct(
        private readonly int $actionMask,
        private readonly array $players
    )
    {
    }

    public function getId(): int
    {
        return 0x3F;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->actionMask);
        $serializer->putVarInt(count($this->players));

        foreach ($this->players as $uuid => $actions) {
            $i = 0;
            $serializer->putUUID($uuid);

            if ($this->actionMask & self::ADD_PLAYER) {
                $property = $actions[$i];
                $serializer->putString($property['name']);

                // Default test values
                $serializer->putVarInt(1); // 1 property
                $serializer->putString("textures");
                $serializer->putString("skin-value");
                $serializer->putBool(false);

                $i++;
            }

            if ($this->actionMask & self::UPDATE_GAMEMODE) {
                $serializer->putVarInt(1); // creative

                $i++;
            }

            if ($this->actionMask & self::UPDATE_LATENCY) {
                $serializer->putVarInt(42); // ping in ms

                $i++;
            }
        }
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        // TODO: Implement read() method.
    }

    public function handle(Session $session): void
    {
        // TODO: Implement handle() method.
    }
}