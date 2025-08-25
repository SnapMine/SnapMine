<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Waterlogged;

class SculkShrieker extends BlockData
{
    private bool $summon = true;
    private bool $shrieking = true;

    use Waterlogged;

    public function computedId(array $data = []): int
    {
        return parent::computedId([
            'can_summon' => $this->summon,
            'shrieking' => $this->shrieking,
        ]);
    }

    /**
     * @param bool $shrieking
     */
    public function setShrieking(bool $shrieking): void
    {
        $this->shrieking = $shrieking;
    }

    /**
     * @return bool
     */
    public function isShrieking(): bool
    {
        return $this->shrieking;
    }

    /**
     * @param bool $summon
     */
    public function setSummon(bool $summon): void
    {
        $this->summon = $summon;
    }

    /**
     * @return bool
     */
    public function canSummon(): bool
    {
        return $this->summon;
    }
}