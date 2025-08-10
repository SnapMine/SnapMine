<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Powerable extends BlockData
{
    public function isPower(): bool;

    public function setPower(bool $power): void;
}