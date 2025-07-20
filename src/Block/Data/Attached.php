<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Attached extends BlockData
{
    public function setAttached(bool $attached): void;

    public function isAttached(): bool;
}