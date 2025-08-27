<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Command\CommandNode;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class CommandsPacket extends ClientboundPacket
{
    /**
     * @param CommandNode[] $nodes
     * @param int $rootIndex
     */
    public function __construct(
        private readonly array $nodes,
        private readonly int $rootIndex,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putVarInt(count($this->nodes));

        foreach ($this->nodes as $node) {
            $flags = $node->computeFlags();
            $serializer->putByte($flags);

            $serializer->putVarInt(count($node->getChildren()));
            foreach ($node->getChildren() as $child) {
                $serializer->putVarInt($child);
            }

            if ($node->getRedirect() !== null) {
                $serializer->putVarInt($node->getRedirect());
            }

            if ($node->getType() === CommandNode::TYPE_LITERAL || $node->getType() === CommandNode::TYPE_ARGUMENT) {
                $serializer->putString($node->getName());
            }

            if ($node->getType() === CommandNode::TYPE_ARGUMENT) {
                $serializer->putString($node->getParser());
                // TODO: serialize properties
            }

            if ($node->getSuggestions() !== null) {
                $serializer->putString($node->getSuggestions());
            }
        }

        // root index
        $serializer->putVarInt($this->rootIndex);
    }

    public function getId(): int
    {
        return 0x10;
    }
}