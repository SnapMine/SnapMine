<?php

namespace SnapMine\Block\Data;

use Exception;

trait Level
{
    protected int $level = 0;

    abstract public function getMaximumLevel(): int;

    /**
     * @throws Exception
     */
    public function setLevel(int $level): void
    {
        if ($level > $this->getMaximumLevel()) {
            throw new Exception("Level $level is out of bounds.");
        }

        $this->level = $level;
    }
    public function getLevel(): int
    {
        return $this->level;
    }
}