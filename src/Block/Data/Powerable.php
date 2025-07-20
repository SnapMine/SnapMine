<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Powerable extends BlockData
{
    public function getPower(): int;

    public function setPower(int $power): void;

    public function getMaximumPower(): int;
}