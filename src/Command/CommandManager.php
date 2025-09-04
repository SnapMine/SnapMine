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


    // Parcours l'arbre -> vérifie l'argument
    // -> Si c'est parsable -> continue le parcours (si les args ne sont pas finis) ->
    // -> Si c'est pas parsable -> on remonte et on recommence le parcours
    // -> Si les args sont terminés et qu'on est sur un nœud exécutable -> on exécute
    // -> Si les args sont terminés et qu'on est pas sur un nœud exécutable -> erreur

    // [LiteralNode("give"), ArgumentNode("player", EntityPlayer), ArgumentNode("item", Item), ArgumentNode("count", Integer)]
    // [LiteralNode("give"), ArgumentNode("player", EntityPlayer), ArgumentNode("item", Item), ArgumentNode("count", Integer)]

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
            Artisan::getLogger()->debug("Plus d'arguments wesh");
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