<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Directional;
use Nirbose\PhpMcServ\Block\Data\Rotatable;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Sign implements Rotatable, Directional, Waterlogged
{
    private int $rotation = 0;
    private bool $waterlogged = false;
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
            'rotation' => $this->rotation,
            'waterlogged' => $this->waterlogged,
        ]);
    }

    public function getRotation(): int
    {
        return $this->rotation;
    }

    public function setRotation(int $rotation): void
    {
        $this->rotation = $rotation;
    }

    public function isWaterlogged(): bool
    {
        return $this->waterlogged;
    }

    public function setWaterlogged(bool $waterlogged): void
    {
        $this->waterlogged = $waterlogged;
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