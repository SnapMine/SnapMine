<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Power;

class DaylightDetector extends BlockData
{
    private bool $inverted = false;

    use Power;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['inverted' => $this->inverted]);
    }

    /**
     * @param bool $inverted
     */
    public function setInverted(bool $inverted): void
    {
        $this->inverted = $inverted;
    }

    /**
     * @return bool
     */
    public function isInverted(): bool
    {
        return $this->inverted;
    }
}