<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Powerable
{
    protected bool $powered = false;

    public function isPowered(): bool
    {
        return $this->powered;
    }

    public function setPowered(bool $powered): void
    {
        $this->powered = $powered;
    }
}