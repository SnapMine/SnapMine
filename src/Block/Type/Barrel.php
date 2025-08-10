<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Directional;
use Nirbose\PhpMcServ\Block\Data\Openable;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Barrel implements Openable, Directional
{
    private bool $open = false;
    private Direction $face;

    public function getMaterial(): Material
    {
        return Material::BARREL;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'facing' => $this->face->value,
            'open' => $this->open,
        ]);
    }

    public function isOpen(): bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): void
    {
        $this->open = $open;
    }

    public function getFaces(): array
    {
        return [
            Direction::NORTH,
            Direction::EAST,
            Direction::SOUTH,
            Direction::WEST,
            Direction::UP,
            Direction::DOWN,
        ];
    }

    public function getFacing(): Direction
    {
        return $this->face;
    }

    public function setFacing(Direction $direction): void
    {
        $this->face = $direction;
    }
}