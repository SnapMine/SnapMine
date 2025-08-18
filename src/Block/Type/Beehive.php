<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Beehive implements BlockData
{
    private int $honeyLevel = 0;

    use Facing;

    public function __construct(
        private readonly Material $material
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->material, [
            'facing' => $this->facing,
            'honey_level' => $this->honeyLevel,
        ]);
    }

    public function getFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    /**
     * @param int $honeyLevel
     */
    public function setHoneyLevel(int $honeyLevel): void
    {
        $this->honeyLevel = $honeyLevel;
    }

    /**
     * @return int
     */
    public function getHoneyLevel(): int
    {
        return $this->honeyLevel;
    }
}