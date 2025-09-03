<?php

namespace SnapMine\Command\Nodes;

use SnapMine\Command\Nodes\CommandNode;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;

class LiteralNode extends CommandNode
{
    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
        $this->setFlag(self::FLAG_TYPE_LITERAL, true);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toPacket(PacketSerializer $serializer): void
    {
        // TODO: Implement toPacket() method.
    }
}