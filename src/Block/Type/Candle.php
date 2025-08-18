<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Lightable;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Material;

class Candle implements BlockData
{
    private int $candles = 1;

    use Lightable, Waterlogged;

    public function __construct(
        private readonly Material $material,
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->material, [
            'candles' => $this->candles,
            'lit' => $this->light,
            'waterlogged' => $this->waterlogged,
        ]);
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