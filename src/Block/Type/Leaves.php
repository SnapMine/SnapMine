<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Distance;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;

class Leaves extends BlockData
{
    private bool $persistent = false;

    use Distance, Waterlogged;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['persistent' => $this->persistent]);
    }

    /**
     * @param bool $persistent
     */
    public function setPersistent(bool $persistent): void
    {
        $this->persistent = $persistent;
    }

    /**
     * @return bool
     */
    public function isPersistent(): bool
    {
        return $this->persistent;
    }
}