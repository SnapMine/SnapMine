<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Directional;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Bed implements Directional
{
    const FOOT = 'foot';
    const HEAD = 'head';

    private bool $occupied = false;
    private string $part = Bed::FOOT;
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

    public function getPart(): string
    {
        return $this->part;
    }

    public function setPart(string $part): void
    {
        if ($part != 'head' || $part != 'foot') {
            // TODO: Throw error
        }

        $this->part = $part;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'facing' => $this->facing->value,
            'occupied' => $this->occupied,
            'part' => $this->part,
        ]);
    }
}