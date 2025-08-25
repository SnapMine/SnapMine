<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Lightable;
use SnapMine\Block\Data\Waterlogged;
use SnapMine\Block\Direction;

class Campfire extends BlockData
{
    private bool $signalFire = false;

    use Facing, Lightable, Waterlogged;


    public function computedId(array $data = []): int
    {
        return parent::computedId(['signal_fire' => $this->signalFire]);
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
}