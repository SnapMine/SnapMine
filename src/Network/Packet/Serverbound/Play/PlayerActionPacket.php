<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Block\Block;
use Nirbose\PhpMcServ\Block\BlockType;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use Nirbose\PhpMcServ\Network\Packet\Serverbound\ServerboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\Position;

class PlayerActionPacket extends ServerboundPacket {
    /** @phpstan-ignore property.onlyWritten */
    private int $status;
    /** @phpstan-ignore property.onlyWritten */
    private Position $position;
    /** @phpstan-ignore property.onlyWritten */
    private int $face;
    /** @phpstan-ignore property.onlyWritten */
    private int $sequence;

    public function getId(): int
    {
        return 0x27;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->status = $serializer->getVarInt();
        $this->position = $serializer->getPosition();
        $this->face = $serializer->getByte();
        $this->sequence = $serializer->getVarInt();
    }

    public function handle(Session $session): void
    {
        switch ($this->status) {
            case 0:
                $this->destroyBlock($session);
                break;
            default:
                break;
        }
    }

    private function destroyBlock(Session $session): void
    {
        $block = new Block($session->getServer(), $this->position, BlockType::AIR->createBlockData());

        $session->getServer()->broadcastPacket(new BlockUpdatePacket($this->position, $block));
    }
}