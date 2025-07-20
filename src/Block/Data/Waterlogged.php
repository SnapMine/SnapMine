<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Waterlogged extends BlockData
{
    public function isWaterlogged(): bool;
    public function setWaterlogged(bool $waterlogged): void;
}