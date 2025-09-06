<?php

namespace SnapMine\Utils;

trait Flags
{
    private int $flags = 0;

    protected function hasFlag(int $flag): bool
    {
        return ($this->flags & $flag) === $flag;
    }

    protected function setFlag(int $flag, bool $value): void
    {
        if ($value) {
            $this->flags |= $flag;
        } else {
            $this->flags &= ~$flag;
        }
    }
}