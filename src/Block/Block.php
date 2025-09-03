<?php

namespace SnapMine\Block;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Entity\Player;
use SnapMine\Material;
use SnapMine\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use SnapMine\Network\Packet\Clientbound\Play\LevelEventPacket;
use SnapMine\Server;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\Location;
use SnapMine\World\Position;
use SnapMine\World\WorldPosition;

class Block
{
    private readonly WorldPosition $location;
    public function __construct(
        private readonly Server   $server,
        WorldPosition $location,
        private BlockData         $blockData,
    )
    {
        $this->location = clone $location;
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

        $this->getChunk()->setBlock($this->location, $this);
    }

    /**
     * @return WorldPosition
     */
    public function getLocation(): WorldPosition
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
        $loc = $this->location;

        $loc->addDirection($direction);

        return $this->getChunk()->getBlock($loc);
    }
    
    public function isWaterloggable(): bool
    {
        return has_trait(Waterlogged::class, $this->blockData);
    }

    public function break(Player $by): void
    {
        $this->server->broadcastPacket(
            new LevelEventPacket(2001, $this->location, $this->blockData->computedId()),
            fn (Player $player) => $player->getUuid() != $by->getUuid()
        );

        $this->setMaterial(Material::AIR);
    }
}