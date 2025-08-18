<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;

class SnowyBlockData extends BasicBlockData
{
    private bool $isSnowy = false;

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'snowy' => $this->isSnowy,
        ]);
    }

    /**
     * @return bool
     */
    public function isSnowy(): bool
    {
        return $this->isSnowy;
    }

    /**
     * @param bool $isSnowy
     */
    public function setIsSnowy(bool $isSnowy): void
    {
        $this->isSnowy = $isSnowy;
    }
}