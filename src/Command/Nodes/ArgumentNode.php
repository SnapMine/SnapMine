<?php

namespace SnapMine\Command\Nodes;

use SnapMine\Command\ArgumentTypes\CommandArgumentType;
use SnapMine\Command\Nodes\CommandNode;

class ArgumentNode extends CommandNode
{

    private string $name;
    private CommandArgumentType $type;

    public function __construct(string $name, CommandArgumentType $type) {
        $this->name = $name;
        $this->type = $type;
        $this->setFlag(self::FLAG_TYPE_ARGUMENT, true);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

}