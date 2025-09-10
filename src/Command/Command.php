<?php

namespace SnapMine\Command;

use Closure;
use SnapMine\Artisan;
use SnapMine\Command\Nodes\LiteralNode;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;

/**
 * Represents a server command with its structure and execution logic.
 * 
 * Commands are used to provide functionality that players and the console
 * can execute. Each command has a tree structure of nodes that define
 * its syntax, arguments, and execution behavior.
 * 
 * Commands implement the Minecraft command protocol for client-side
 * tab completion and syntax highlighting.
 * 
 * @since   0.0.1
 * 
 * @example
 * ```php
 * $command = Command::new('teleport', function($sender, $args) {
 *     // Teleport logic here
 * })
 * ->argument('player', CommandArgumentType::entity())
 * ->argument('x', CommandArgumentType::integer())
 * ->argument('y', CommandArgumentType::integer())
 * ->argument('z', CommandArgumentType::integer())
 * ->build();
 * ```
 */
class Command implements ProtocolEncodable
{
    /**
     * The root node of the command tree.
     * 
     * @var LiteralNode
     */
    protected LiteralNode $root;
    
    /**
     * Index of this command in the command manager.
     * 
     * @var int
     */
    private int $index;

    /**
     * Private constructor to enforce factory method usage.
     */
    private function __construct()
    {
        $this->index = count(Artisan::getCommandManager()->getNodes());
    }

    /**
     * Create a new command with the specified name and optional executor.
     * 
     * @param string       $name     The command name (e.g., 'teleport', 'give')
     * @param Closure|null $executor Optional closure to execute when command is run
     * @return LiteralNode The root node for building the command structure
     * 
     * @example
     * ```php
     * Command::new('hello', function($sender) {
     *     $sender->sendMessage('Hello, world!');
     * })->build();
     * ```
     */
    public static function new(string $name, ?Closure $executor = null): LiteralNode
    {
        $me = new self();
        // Pass the index by reference so it's shared
        $baseIndex = $me->index;
        $me->root = new LiteralNode($me, $baseIndex, $name, $executor);

        return $me->root;
    }
    
    /**
     * Get the root node of this command.
     * 
     * @return LiteralNode The root literal node
     */
    public function getRoot(): LiteralNode
    {
        return $this->root;
    }

    /**
     * Build and register the command with the command manager.
     * 
     * This method finalizes the command structure and registers it
     * with the server's command system, making it available for execution.
     * 
     * @return self This command instance for method chaining
     */
    public function build(): self
    {
        //$nodes = array_merge([$this->root], $this->root->getAllNodes());
        $nodes = $this->root->getAllNodes();

        Artisan::getCommandManager()->addNodes($nodes);
        Artisan::getCommandManager()->add($this);

        return $this;
    }

    /**
     * Encode the command structure for network transmission.
     * 
     * This method serializes the command tree for sending to clients,
     * enabling client-side tab completion and syntax highlighting.
     * 
     * @param PacketSerializer $serializer The packet serializer to write to
     * @return void
     */
    public function encode(PacketSerializer $serializer): void
    {
        $this->root->encode($serializer);
        $serializer->putVarInt(0);
    }
}