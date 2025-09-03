<?php

namespace SnapMine\Command\Nodes;

use InvalidArgumentException;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;
use SnapMine\Utils\BitSet;
use SnapMine\Utils\Flags;

abstract class CommandNode implements ProtocolEncodable
{
    use Flags;

    const FLAG_TYPE_LITERAL = 0x1;
    const FLAG_TYPE_ARGUMENT = 0x2;
    const FLAG_IS_EXECUTABLE = 0x4;
    const FLAG_HAS_REDIRECT = 0x8;
    const FLAG_HAS_SUGGESTIONS_TYPE = 0x10;
    const FLAG_IS_REDIRECT = 0x20;

    /** @var CommandNode[] */
    protected array $children = [];
    protected ?int $redirect = null;
    protected ?string $suggestions = null;
    protected int $nodeIndex = 0;

    protected RootNode $root;


    public function setNodeIndex(int $index): void
    {
        $this->nodeIndex = $index;
    }

    public function setRoot(RootNode $root): void
    {
        $this->root = $root;
    }


    public function addChild(CommandNode $node): void
    {
        if ($node === $this) {
            throw new InvalidArgumentException("Cannot add self as child");
        }

        $index = $this->root->addToNodes($node);
        $node->setNodeIndex($index);
        $node->setRoot($this->root);
        $this->children[] = $node;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    protected function encodeNodeHeader(PacketSerializer $serializer): void {
        $serializer->putByte($this->flags)->putVarInt(count($this->children));
        foreach ($this->children as $child) {
            $serializer->putVarInt($child->nodeIndex);
        }
        if ($this->hasFlag(self::FLAG_HAS_REDIRECT) && $this->redirect !== null) {
            $serializer->putVarInt($this->redirect);
        }
    }


}