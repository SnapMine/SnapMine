<?php

namespace SnapMine\Command\Nodes;

use Closure;
use SnapMine\Command\Command;
use SnapMine\Network\Serializer\PacketSerializer;

class LiteralNode extends CommandNode
{

    public function __construct(
        CommandNode|Command $parent,
        int                 &$index,
        protected string    $name,
        ?Closure            $executor = null,
    )
    {
        parent::__construct($parent, $executor, $index);

        $this->setFlag(CommandNode::FLAG_TYPE_LITERAL, true);
    }

    protected function encodeProperties(PacketSerializer $serializer): void
    {
        $serializer->putString($this->name);
    }

}