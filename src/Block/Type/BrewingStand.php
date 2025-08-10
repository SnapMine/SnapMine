<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
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

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'has_bottle_0' => $this->hasBottle(0),
            'has_bottle_1' => $this->hasBottle(1),
            'has_bottle_2' => $this->hasBottle(2),
        ]);
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