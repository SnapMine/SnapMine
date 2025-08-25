<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Direction;

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