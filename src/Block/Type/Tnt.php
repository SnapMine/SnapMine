<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;

class Tnt extends BlockData
{
    private bool $unstable = false;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['unstable' => $this->unstable]);
    }

    /**
     * @param bool $unstable
     */
    public function setUnstable(bool $unstable): void
    {
        $this->unstable = $unstable;
    }

    /**
     * @return bool
     */
    public function isUnstable(): bool
    {
        return $this->unstable;
    }
}