<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class Lectern extends BlockData
{
    private bool $hasBook = false;

    use Facing, Powerable;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['has_book' => $this->hasBook]);
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
     * @param bool $hasBook
     */
    public function setHasBook(bool $hasBook): void
    {
        $this->hasBook = $hasBook;
    }

    /**
     * @return bool
     */
    public function isHasBook(): bool
    {
        return $this->hasBook;
    }
}