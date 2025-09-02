<?php

namespace SnapMine\Command;

class LiteralNode extends RootNode
{
    protected int $type = 1;

    public function __construct(
        protected readonly string $name,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}