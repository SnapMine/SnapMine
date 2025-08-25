<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Lightable;
use SnapMine\Block\Data\Waterlogged;

class Candle extends BlockData
{
    private int $candles = 1;

    use Lightable, Waterlogged;


    public function computedId(array $data = []): int
    {
        return parent::computedId(['candles' => $this->candles]);
    }

    /**
     * @param int $candles
     */
    public function setCandles(int $candles): void
    {
        $this->candles = $candles;
    }

    /**
     * @return int
     */
    public function getCandles(): int
    {
        return $this->candles;
    }
}