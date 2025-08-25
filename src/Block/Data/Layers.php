<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Layers
{
    protected int $layers = 1;

    /**
     * @return int
     */
    public function getLayers(): int
    {
        return $this->layers;
    }

    /**
     * @param int $layers
     */
    public function setLayers(int $layers): void
    {
        $this->layers = $layers;
    }
}