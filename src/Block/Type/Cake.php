<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
class Cake extends BlockData
{
    private int $bits = 6;

    public function computedId(array $data = []): int
    {
        return $this->getMaterial()->getBlockId() + $this->bits;
    }

    /**
     * @param int $bits
     */
    public function setBits(int $bits): void
    {
        $this->bits = $bits;
    }

    /**
     * @return int
     */
    public function getBits(): int
    {
        return $this->bits;
    }
}