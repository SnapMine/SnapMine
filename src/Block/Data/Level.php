<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Level extends BlockData
{
    public function getMaximumLevel(): int;

    public function setLevel(int $level): void;
    public function getLevel(): int;
}