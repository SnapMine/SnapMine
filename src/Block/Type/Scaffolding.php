<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Distance;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;

class Scaffolding extends BlockData
{
    private bool $bottom = false;

    use Distance, Waterlogged;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['bottom' => $this->bottom]);
    }

    /**
     * @return bool
     */
    public function isBottom(): bool
    {
        return $this->bottom;
    }

    /**
     * @param bool $bottom
     */
    public function setBottom(bool $bottom): void
    {
        $this->bottom = $bottom;
    }
}