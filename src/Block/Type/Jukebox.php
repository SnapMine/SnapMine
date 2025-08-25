<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;

class Jukebox extends BlockData
{
    private bool $has_record = false;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['has_record' => $this->has_record]);
    }

    /**
     * @param bool $has_record
     */
    public function setRecord(bool $has_record): void
    {
        $this->has_record = $has_record;
    }

    /**
     * @return bool
     */
    public function hasRecord(): bool
    {
        return $this->has_record;
    }
}