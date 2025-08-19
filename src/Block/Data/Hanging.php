<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Hanging
{
    protected bool $hanging = false;

    /**
     * @param bool $hanging
     */
    public function setHanging(bool $hanging): void
    {
        $this->hanging = $hanging;
    }

    /**
     * @return bool
     */
    public function isHanging(): bool
    {
        return $this->hanging;
    }
}