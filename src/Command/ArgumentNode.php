<?php

namespace SnapMine\Command;

class ArgumentNode extends LiteralNode
{
    protected int $type = 2;

    public function __construct(
        private readonly int $parserId,
    )
    {
    }
}