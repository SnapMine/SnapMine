<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Orientable;
use Nirbose\PhpMcServ\Block\Data\Triggered;

class Crafter extends BlockData
{
    private bool $crafting = false;

    use Orientable, Triggered;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['crafting' => $this->crafting]);
    }

    /**
     * @param bool $crafting
     */
    public function setCrafting(bool $crafting): void
    {
        $this->crafting = $crafting;
    }

    /**
     * @return bool
     */
    public function isCrafting(): bool
    {
        return $this->crafting;
    }
}