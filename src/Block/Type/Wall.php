<?php

namespace Nirbose\PhpMcServ\Block\Type;

use InvalidArgumentException;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Block\WallHeight;

class Wall extends BlockData
{
    /** @var array<string, WallHeight> */
    private array $heights = [];

    use Waterlogged;

    public function computedId(array $data = []): int
    {
        foreach (Direction::cases() as $direction) {
            if ($direction == Direction::DOWN)
                continue;

            $data[$direction->value] = $this->getHeight($direction);
        }

        return parent::computedId($data);
    }

    public function setHeight(Direction $direction, WallHeight $height): void
    {
        if ($direction == Direction::DOWN) {
            throw new InvalidArgumentException('Direction cannot be down');
        }

        $this->heights[$direction->value] = $height;
    }

    public function getHeight(Direction $direction): WallHeight
    {
        if (isset($this->heights[$direction->value])) {
            return $this->heights[$direction->value];
        }

        return WallHeight::NONE;
    }
}