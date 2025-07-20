<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Lightable extends BlockData
{
    public function setLit(bool $lit): void;

    public function isLit(): bool;
}