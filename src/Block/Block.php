<?php

namespace Nirbose\PhpMcServ\Block;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Chunk\Chunk;
use Nirbose\PhpMcServ\World\Location;

class Block
{
    public function __construct(
        private readonly Server   $server,
        private readonly Location $location,
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
     * @return Location
     */
    public function getLocation(): Location
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

        return $this->server->getRegion()->getChunk($x, $z);
    }

    /**
     * @return BlockData
     */
    public function getBlockData(): BlockData
    {
        return $this->blockData;
    }
}