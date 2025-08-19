<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Mode;

class ModeBlockData extends BlockData
{
    private Mode $mode = Mode::DATA;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['mode' => $this->mode]);
    }

    /**
     * @param Mode $mode
     */
    public function setMode(Mode $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @return Mode
     */
    public function getMode(): Mode
    {
        return $this->mode;
    }
}