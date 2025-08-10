<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Waterlogged
{
    protected bool $waterlogged = false;

    public function isWaterlogged(): bool
    {
        return $this->waterlogged;
    }
    public function setWaterlogged(bool $waterlogged): void
    {
        $this->waterlogged = $waterlogged;
    }
}