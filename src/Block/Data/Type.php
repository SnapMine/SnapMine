<?php

namespace SnapMine\Block\Data;

trait Type
{
    protected string $type = "left";

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

}