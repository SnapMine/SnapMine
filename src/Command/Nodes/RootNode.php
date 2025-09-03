<?php

namespace SnapMine\Command\Nodes;

use SnapMine\Command\Nodes\CommandNode;

class RootNode extends CommandNode
{

    private array $nodes = [];

    public function __construct() {
        $this->nodes[] = $this;
    }

    public function addToNodes(CommandNode $node): int
    {
        $this->nodes[] = $node;
        return count($this->nodes) - 1;
    }

}