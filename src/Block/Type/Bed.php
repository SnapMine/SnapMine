<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Direction;

class Bed extends BlockData
{
    use Facing;

    const FOOT = 'foot';
    const HEAD = 'head';

    private bool $occupied = false;
    private string $part = Bed::FOOT;

    public function getFaces(): array
    {
        return [
            Direction::NORTH,
            Direction::SOUTH,
            Direction::WEST,
            Direction::EAST,
        ];
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
        if ($part != 'head' && $part != 'foot') {
            // TODO: Throw error
        }

        $this->part = $part;
    }

    public function computedId(array $data = []): int
    {
        return parent::computedId(['part' => $this->part, 'occupied' => $this->occupied]);
    }
}