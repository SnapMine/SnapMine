<?php

namespace SnapMine\Command;

use Closure;
use SnapMine\Artisan;
use SnapMine\Command\Nodes\LiteralNode;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;

class Command implements ProtocolEncodable
{
    protected LiteralNode $root;
    private int $index;

    private function __construct()
    {
        $this->index = count(Artisan::getCommandManager()->getNodes());
    }

    public static function new(string $name, ?Closure $executor = null): LiteralNode
    {
        $me = new self();
        // Passer l'index par référence pour qu'il soit partagé
        $baseIndex = $me->index;
        $me->root = new LiteralNode($me, $baseIndex, $name, $executor);

        return $me->root;
    }

    /**
     * @return LiteralNode
     */
    public function getRoot(): LiteralNode
    {
        return $this->root;
    }

    public function build(): self
    {
        //$nodes = array_merge([$this->root], $this->root->getAllNodes());
        $nodes = $this->root->getAllNodes();

        Artisan::getCommandManager()->addNodes($nodes);
        Artisan::getCommandManager()->add($this);

        return $this;
    }

    public function encode(PacketSerializer $serializer): void
    {
        $this->root->encode($serializer);
        $serializer->putVarInt(0);
    }
}