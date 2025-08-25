<?php

namespace SnapMine\Block\Data;

trait Lightable
{
    protected bool $light = false;

    public function setLit(bool $lit): void
    {
        $this->light = $lit;
    }

    public function isLit(): bool
    {
        return $this->light;
    }
}