<?php

namespace SnapMine\Command;

use InvalidArgumentException;
use SnapMine\Artisan;
use SnapMine\Command\Nodes\ArgumentNode;
use SnapMine\Command\Nodes\CommandNode;
use SnapMine\Command\Nodes\LiteralNode;
use SnapMine\Entity\Player;
use SnapMine\Network\Serializer\ProtocolEncodable;

class CommandManager
{
    /** @var CommandNode[] */
    private array $nodes = [];
    /** @var Command[] */
    private array $commands = [];


    public function __construct()
    {
    }

    public function getNodes(): array
    {
        return $this->nodes;
    }

    public function addNodes(array $nodes): void
    {
        $this->nodes = array_merge($this->nodes, $nodes);
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function add(Command $command): void
    {
        $this->commands[] = $command;
    }

    public function execute(Player $player, array $args): void
    {
        foreach ($this->commands as $command) {
            $root = $command->getRoot();
            if ($root->getName() === $args[0]) {
                $ret = $this->findExecutableNode($root, array_slice($args, 1));

                if ($ret !== null) {
                    [$executor, $executorArgs] = $ret;
                    $executor($player, ...$executorArgs);
                } else {
                    $player->sendMessage("Invalid command usage for command: " . $root->getName());
                }

                break;
            }
        }
    }

    private function findExecutableNode(CommandNode $node, array $args, array $executorArgs = []): ?array
    {
        if (count($args) === 0) {
            if ($node->isExecutable()) {
                return [$node->getExecutor(), $executorArgs];
            }

            return null;
        }

        foreach ($node->getChildren() as $child) {
            if ($child instanceof LiteralNode) {
                if ($child->getName() === $args[0]) {
                    $ret = $this->findExecutableNode($child, array_slice($args, 1), $executorArgs);

                    if ($ret !== null) {
                        return $ret;
                    }
                }
            } else if ($child instanceof ArgumentNode) {
                $ret = $child->getType()->parse($args);
                if ($ret !== null) {
                    [$newArgs, $newExecutorArg] = $ret;
                    $ret = $this->findExecutableNode($child, $newArgs, array_merge($executorArgs, [$newExecutorArg]));

                    if ($ret !== null) {
                        return $ret;
                    }
                }
            }
        }
        return null;
    }

}