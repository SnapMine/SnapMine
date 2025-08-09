<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockCoefficient;
use Nirbose\PhpMcServ\Block\Data\Directional;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Bed implements Directional
{
    const FOOT = 0;
    const HEAD = 1;

    private bool $occupied = false;
    private int $part = Bed::FOOT;
    private Direction $facing = Direction::EAST;

    public function __construct(
        private readonly Material $material
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function getFaces(): array
    {
        return [
            Direction::NORTH,
            Direction::SOUTH,
            Direction::WEST,
            Direction::EAST,
        ];
    }

    public function getFacing(): Direction
    {
        return $this->facing;
    }

    public function setFacing(Direction $direction): void
    {
        $this->facing = $direction;
    }

    public function isOccupied(): bool
    {
        return $this->occupied;
    }

    public function setOccupied(bool $occupied): void
    {
        $this->occupied = $occupied;
    }

    public function getPart(): int
    {
        return $this->part;
    }

    public function setPart(int $part): void
    {
        if ($part < 0 || $part > 1) {
            // TODO: Throw error
        }

        $this->part = $part;
    }

    public function computedId(): int
    {
        return $this->material->getBlockId() + get_block_state_offset([
                'facing' => array_search($this->facing, $this->getFaces()),
                'occupied' => (int)!$this->occupied,
                'part' => !$this->part,
            ], BlockCoefficient::getCoefficient('minecraft:' . $this->material->name));
    }
}