<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Half;
use Nirbose\PhpMcServ\Block\Data\Openable;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Direction;

class Door extends BlockData
{
    use Facing, Half, Openable, Powerable;
    private string $hinge = 'left';


    public function computedId(array $data = []): int
    {
        return parent::computedId(['hinge' => $this->hinge]);
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