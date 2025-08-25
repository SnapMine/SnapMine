<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Direction;
use SnapMine\Block\WallHeight;

class PaleMossCarpet extends BlockData
{
    private bool $bottom = false;
    /** @var array<string, WallHeight> */
    private array $faces = [];

    public function computedId(array $data = []): int
    {
        $data['bottom'] = $this->bottom;
        /** @var Direction[] $directions */
        $directions = [Direction::EAST, Direction::WEST, Direction::SOUTH, Direction::NORTH];

        foreach ($directions as $direction) {
            $data[$direction->value] = $this->getHeight($direction);
        }

        return parent::computedId($data);
    }

    /**
     * @param bool $bottom
     */
    public function setBottom(bool $bottom): void
    {
        $this->bottom = $bottom;
    }

    /**
     * @return bool
     */
    public function isBottom(): bool
    {
        return $this->bottom;
    }

    public function getHeight(Direction $direction): WallHeight
    {
        if (isset($this->faces[$direction->value])) {
            return $this->faces[$direction->value];
        }

        return WallHeight::NONE;
    }

    public function setHeight(Direction $direction, WallHeight $height): void
    {
        $this->faces[$direction->value] = $height;
    }
}