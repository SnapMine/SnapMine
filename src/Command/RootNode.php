<?php

namespace SnapMine\Command;

class RootNode
{
    protected int $type = 0;
    protected array $children = [];

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChild(LiteralNode $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    public function countChildren(): int
    {
        return count($this->children);
    }

    public function computeFlags(): int
    {
        $flags = ($this->type & 0x03);
        if ($this->countChildren() === 0) $flags |= 0x04;

        return $flags & 0xFF;
    }
}