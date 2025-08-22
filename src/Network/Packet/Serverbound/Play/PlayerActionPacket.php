<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Play;

use Nirbose\PhpMcServ\Block\Block;
use Nirbose\PhpMcServ\Block\BlockType;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\BlockChangedAckPacket;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\BlockDestructionPacket;
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
        $session->sendPacket(new BlockChangedAckPacket($this->sequence));

        switch ($this->status) {
            case 0:
                $session->getServer()->broadcastPacket(new BlockDestructionPacket($session->getPlayer(), $this->position, 2)); // TODO: Compute stage
                break;
            case 1:
                $session->getServer()->broadcastPacket(new BlockDestructionPacket($session->getPlayer(), $this->position, -1));
                break;
            case 2:
                $this->destroyBlock($session); // TODO: Verify player completed the destruction
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