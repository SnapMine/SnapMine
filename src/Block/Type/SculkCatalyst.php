<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;

class SculkCatalyst extends BlockData
{
    private bool $bloom = false;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['bloom' => $this->bloom]);
    }

    /**
     * @param bool $bloom
     */
    public function setBloom(bool $bloom): void
    {
        $this->bloom = $bloom;
    }

    /**
     * @return bool
     */
    public function isBloom(): bool
    {
        return $this->bloom;
    }
}