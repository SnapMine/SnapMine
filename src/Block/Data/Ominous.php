<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Ominous
{
    protected bool $ominous = true;

    /**
     * @param bool $ominous
     */
    public function setOminous(bool $ominous): void
    {
        $this->ominous = $ominous;
    }

    /**
     * @return bool
     */
    public function isOminous(): bool
    {
        return $this->ominous;
    }
}