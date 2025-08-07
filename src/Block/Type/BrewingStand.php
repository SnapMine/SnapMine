<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Material;

class BrewingStand implements BlockData
{
    private array $bottles = [
        false,
        false,
        false,
    ];

    public function getMaterial(): Material
    {
        return Material::BREWING_STAND;
    }

    public function computedId(): int
    {
        return Material::BREWING_STAND->getBlockId() + get_block_state_offset($this->bottles, [1]);
    }

    /**
     * @return bool[]
     */
    public function getBottles(): array
    {
        return $this->bottles;
    }

    public function getMaximumBottles(): int
    {
        return 3;
    }

    public function setBottle(int $index, bool $has) {
        if ($index < 0 || $index > $this->getMaximumBottles()) {
            // TODO: Throw error
        }

        $this->bottles[$index] = $has;
    }

    public function hasBottle(int $index): bool
    {
        return $this->bottles[$index];
    }
}