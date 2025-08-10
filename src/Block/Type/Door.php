<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Openable;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Door extends GenericBisected implements BlockData
{
    use Facing, Openable, Powerable, Waterlogged;
    private string $hinge = 'left';

    public function __construct(Material $material)
    {
        parent::__construct($material);
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'facing' => $this->facing->value,
            'open' => $this->open,
            'waterlogged' => $this->waterlogged,
            'power' => $this->isPower(),
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