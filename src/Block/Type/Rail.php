<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\RailShape;

class Rail extends BlockData
{
    protected RailShape $shape = RailShape::ASCENDING_EAST;

    use Waterlogged;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['shape' => $this->shape]);
    }

    /**
     * @param RailShape $shape
     */
    public function setShape(RailShape $shape): void
    {
        $this->shape = $shape;
    }

    /**
     * @return RailShape
     */
    public function getShape(): RailShape
    {
        return $this->shape;
    }
}