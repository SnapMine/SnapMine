<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Openable extends BlockData
{
    public function isOpen(): bool;

    public function setOpen(bool $open): void;
}