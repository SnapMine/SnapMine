<?php

namespace SnapMine\Command\Nodes;

use Closure;
use SnapMine\Command\ArgumentTypes\CommandArgumentType;
use SnapMine\Network\Serializer\PacketSerializer;

class ArgumentNode extends CommandNode
{


    public function __construct(
        ?CommandNode                  $parent,
        int                           &$index,
        protected string              $name,
        protected CommandArgumentType $type,
        ?Closure                      $executor = null
    )
    {
        parent::__construct($parent, $executor, $index);
        $this->setFlag(CommandNode::FLAG_TYPE_ARGUMENT, true);

    }

    protected function encodeProperties(PacketSerializer $serializer): void
    {
        $serializer->putString($this->name);
        $serializer->putVarInt($this->type::getNumericId());
        $this->type->encodeProperties($serializer);
    }
}