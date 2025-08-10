<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Openable;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Door extends GenericBisected implements Waterlogged, Facing, Powerable, Openable
{
    private Direction $direction;
    private bool $power = false;
    private bool $open = false;
    private bool $waterlogged = false;
    private string $hinge = 'left';

    public function __construct(Material $material)
    {
        parent::__construct($material);

        $this->direction = $this->getFaces()[0];
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'facing' => $this->direction->value,
            'open' => $this->open,
            'waterlogged' => $this->waterlogged,
            'power' => $this->power,
            'half' => $this->getHalf(),
            'hinge' => $this->hinge,
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

    public function isOpen(): bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): void
    {
        $this->open = $open;
    }

    public function isPower(): bool
    {
        return $this->power;
    }

    public function setPower(bool $power): void
    {
        $this->power = $power;
    }

    public function isWaterlogged(): bool
    {
        return $this->waterlogged;
    }

    public function setWaterlogged(bool $waterlogged): void
    {
        $this->waterlogged = $waterlogged;
    }

    /**
     * @param string $hinge
     */
    public function setHinge(string $hinge): void
    {
        $this->hinge = $hinge;
    }

    /**
     * @return string
     */
    public function getHinge(): string
    {
        return $this->hinge;
    }
}