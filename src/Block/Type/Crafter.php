<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Block;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Interactable;
use SnapMine\Block\Data\Orientable;
use SnapMine\Block\Data\Triggered;
use SnapMine\Entity\Player;
use SnapMine\Inventory\CrafterInventory;

class Crafter extends BlockData implements Interactable
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

    public function interact(Player $player, Block $block): bool
    {
        $player->openInventory(new CrafterInventory());

        return true;
    }
}