<?php

namespace SnapMine\Block;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Material;
use SnapMine\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use SnapMine\Server;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\Position;

class Block
{
    public function __construct(
        private readonly Server   $server,
        private readonly Position $location,
        private BlockData         $blockData,
    )
    {
    }

    /**
     * @return Material
     */
    public function getMaterial(): Material
    {
        return $this->blockData->getMaterial();
    }

    /**
     * @param Material $material
     */
    public function setMaterial(Material $material): void
    {
        $this->blockData = BlockType::find($material)->createBlockData();

        $this->server->broadcastPacket(new BlockUpdatePacket($this->location, $this));
    }

    /**
     * @return Position
     */
    public function getLocation(): Position
    {
        return $this->location;
    }

    public function getX(): int
    {
        return (int) $this->location->getX();
    }

    public function getY(): int
    {
        return (int) $this->location->getY();
    }

    public function getZ(): int
    {
        return (int) $this->location->getZ();
    }

    public function getChunk(): Chunk
    {
        $x = $this->getX() >> 4;
        $z = $this->getZ() >> 4;

        return $this->server->getWorld("world")->getChunk($x, $z);
    }

    /**
     * @return BlockData
     */
    public function getBlockData(): BlockData
    {
        return $this->blockData;
    }

    public function getRelative(Direction $direction): Block
    {
        $loc = clone $this->location;

        $loc->add($direction);

        return $this->getChunk()->getBlock((int)$loc->getX(), (int)$loc->getY(), (int)$loc->getZ());
    }
    
    public function isWaterloggable(): bool
    {
        return has_trait(Waterlogged::class, $this->blockData);
    }
}