<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Powerable
{
    protected bool $isPower = false;

    public function isPower(): bool
    {
        return $this->isPower;
    }

    public function setPower(bool $power): void
    {
        $this->isPower = $power;
    }
}