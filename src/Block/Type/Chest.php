<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Chest implements Facing, Waterlogged
{
    private string $type = 'left';
    private bool $waterlogged = false;
    private Direction $direction;

    public function __construct()
    {
        $this->direction = $this->getFaces()[0];
    }

    public function getMaterial(): Material
    {
        return Material::CHEST;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'facing' => $this->direction,
            'waterlogged' => $this->waterlogged,
            'type' => $this->type,
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

    public function isWaterlogged(): bool
    {
        return $this->waterlogged;
    }

    public function setWaterlogged(bool $waterlogged): void
    {
        $this->waterlogged = $waterlogged;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}