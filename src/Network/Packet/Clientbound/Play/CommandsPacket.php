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
                $serializer->putBool(true);
                $serializer->putVarInt($node->getRedirect());
            } else {
//                $serializer->putBool(false);
            }

            if ($node->getType() === CommandNode::TYPE_LITERAL || $node->getType() === CommandNode::TYPE_ARGUMENT) {
                $serializer->putBool(true);
                $serializer->putString($node->getName());
            }

            if ($node->getType() === CommandNode::TYPE_ARGUMENT) {
                if (is_null($node->getParser())) {
                    $serializer->putBool(false);
                    $serializer->putBool(false);
                } else {
                    $serializer->putBool(true);
                    $serializer->putString($node->getParser());
                    // TODO: serialize properties
                }
            }

            if ($node->getSuggestions() !== null) {
                $serializer->putBool(true);
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