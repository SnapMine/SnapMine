<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Block\Block;
use SnapMine\Block\BlockType;
use SnapMine\Network\Packet\Clientbound\Play\BlockChangedAckPacket;
use SnapMine\Network\Packet\Clientbound\Play\BlockDestructionPacket;
use SnapMine\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;
use SnapMine\World\Position;

class PlayerActionPacket extends ServerboundPacket {
    private int $status;
    private Position $position;
    /** @phpstan-ignore property.onlyWritten */
    private int $face;
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