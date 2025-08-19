<?php

namespace Nirbose\PhpMcServ\Block\Type;

use InvalidArgumentException;
use Nirbose\PhpMcServ\Block\Data\BlockData;

class RespawnAnchor extends BlockData
{
    private int $charges = 0;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['charges' => $this->charges]);
    }

    /**
     * @param int $charges
     */
    public function setCharge(int $charges): void
    {
        if ($charges > 4 || $charges < 0) {
            throw new InvalidArgumentException('Charges must be between 0 and 4.');
        }

        $this->charges = $charges;
    }

    /**
     * @return int
     */
    public function getCharges(): int
    {
        return $this->charges;
    }
}