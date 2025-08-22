<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Lightable;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;

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