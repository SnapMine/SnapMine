<?php

namespace Nirbose\PhpMcServ\Block\Type;

use InvalidArgumentException;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;

class SeaPickle extends BlockData
{
    private int $pickles = 1;

    use Waterlogged;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['pickles' => $this->pickles]);
    }

    /**
     * @param int $pickles
     */
    public function setPickles(int $pickles): void
    {
        if ($pickles < 1 || $pickles > 4) {
            throw new InvalidArgumentException('Pickles must be between 1 and 4.');
        }

        $this->pickles = $pickles;
    }

    /**
     * @return int
     */
    public function getPickles(): int
    {
        return $this->pickles;
    }
}