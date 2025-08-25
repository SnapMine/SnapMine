<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Orientable;
use SnapMine\Block\Data\Triggered;

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