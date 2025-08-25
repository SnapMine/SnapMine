<?php

namespace SnapMine\Block\Type;

use InvalidArgumentException;

class TurtleEgg extends HatchBlockData
{
    private int $eggs = 1;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['eggs' => $this->eggs]);
    }

    /**
     * @param int $eggs
     */
    public function setEggs(int $eggs): void
    {
        if ($eggs < 1 || $eggs > 4) {
            throw new InvalidArgumentException('Eggs must be between 1 and 4');
        }

        $this->eggs = $eggs;
    }

    /**
     * @return int
     */
    public function getEggs(): int
    {
        return $this->eggs;
    }
}