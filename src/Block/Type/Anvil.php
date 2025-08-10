<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Directional;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Anvil implements Directional
{
    private Direction $direction;

    public function __construct(
        private readonly Material $material,
    )
    {
        $this->direction = $this->getFaces()[0];
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->material, [
            'facing' => $this->direction,
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

    public function getFacing(): Direction
    {
        return $this->direction;
    }

    public function setFacing(Direction $direction): void
    {
        $this->direction = $direction;
    }
}