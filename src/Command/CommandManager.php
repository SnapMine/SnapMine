<?php

namespace SnapMine\Command;

use InvalidArgumentException;
use SnapMine\Command\Nodes\ArgumentNode;
use SnapMine\Command\Nodes\CommandNode;
use SnapMine\Command\Nodes\LiteralNode;
use SnapMine\Entity\Player;
use SnapMine\Network\Serializer\ProtocolEncodable;

class CommandManager
{
    /** @var CommandNode[] */
    private array $nodes = [];
    /** @var Command */
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

    /**
     * Exécute une commande à partir d'une liste d'arguments
     *
     * @param Player $player Le joueur qui exécute la commande
     * @param array $args Liste des arguments de la commande (string[])
     * @return bool True si la commande a été exécutée avec succès, false sinon
     */
    public function execute(Player $player, array $args): bool
    {
        if (empty($args)) {
            return false;
        }

        $commandName = array_shift($args);

        // Trouver la commande racine correspondante
        $rootNode = $this->findRootCommand($commandName);
        if ($rootNode === null) {
            return false;
        }

        // Parcourir l'arbre de commandes et parser les arguments
        $result = $this->parseCommandPath($rootNode, $args);
        if ($result === null) {
            return false;
        }

        [$executorNode, $parsedArgs] = $result;

        // Exécuter la commande si elle a un executor
        return $this->executeNode($executorNode, $player, $parsedArgs);
    }

    /**
     * Parse le chemin de commande et les arguments selon leurs types
     */
    private function parseCommandPath(CommandNode $startNode, array $rawArgs): ?array
    {
        $currentNode = $startNode;
        $lastExecutableNode = $startNode->hasExecutor() ? $startNode : null;
        $parsedArgs = [];
        $argIndex = 0;

        foreach ($rawArgs as $rawArg) {
            $childNode = $this->findMatchingChild($currentNode, $rawArg);
            if ($childNode === null) {
                break;
            }

            // Si c'est un ArgumentNode, parser l'argument selon son type
            if ($childNode instanceof ArgumentNode) {
                $argumentType = $this->getNodeArgumentType($childNode);
                if ($argumentType !== null) {
                    try {
                        $argumentType->setValue($this->parseArgument($argumentType, $rawArg));
                        $parsedArgs[] = $argumentType;
                    } catch (\Exception $e) {
                        // Argument invalide
                        return null;
                    }
                }
            }

            $currentNode = $childNode;
            if ($currentNode->hasExecutor()) {
                $lastExecutableNode = $currentNode;
            }
            $argIndex++;
        }

        return $lastExecutableNode ? [$lastExecutableNode, $parsedArgs] : null;
    }

    /**
     * Parse un argument selon son type
     */
    private function parseArgument($argumentType, string $rawValue): mixed
    {
        if ($argumentType instanceof \SnapMine\Command\ArgumentTypes\BrigadierString) {
            return $rawValue;
        }

        if ($argumentType instanceof \SnapMine\Command\ArgumentTypes\BrigadierInteger) {
            $intValue = filter_var($rawValue, FILTER_VALIDATE_INT);
            if ($intValue === false) {
                throw new InvalidArgumentException("Invalid integer: $rawValue");
            }
            return $intValue;
        }

        // Type par défaut
        return $rawValue;
    }

    /**
     * Exécute le nœud avec le joueur et les arguments parsés
     */
    private function executeNode(CommandNode $node, Player $player, array $parsedArgs): bool
    {
        $executor = $this->getNodeExecutor($node);
        if ($executor === null) {
            return false;
        }

        try {
            // Le joueur est toujours le premier paramètre, suivi des arguments parsés
            $executor($player, ...$parsedArgs);
            return true;
        } catch (\Exception $e) {
            // Log l'erreur si nécessaire
            return false;
        }
    }

    // Méthodes utilitaires pour accéder aux propriétés protégées des nœuds
    private function getNodeName(CommandNode $node): ?string
    {
        if ($node instanceof LiteralNode) {
            $reflection = new \ReflectionClass($node);
            $nameProperty = $reflection->getProperty('name');
            $nameProperty->setAccessible(true);
            return $nameProperty->getValue($node);
        }
        return null;
    }

    private function getNodeChildren(CommandNode $node): array
    {
        $reflection = new \ReflectionClass($node);
        $childrenProperty = $reflection->getProperty('children');
        $childrenProperty->setAccessible(true);
        return $childrenProperty->getValue($node);
    }

    private function getNodeExecutor(CommandNode $node): ?\Closure
    {
        $reflection = new \ReflectionClass($node);
        $executorProperty = $reflection->getProperty('executor');
        $executorProperty->setAccessible(true);
        return $executorProperty->getValue($node);
    }

    /**
     * Récupère le type d'argument d'un ArgumentNode
     */
    private function getNodeArgumentType(ArgumentNode $node): ?\SnapMine\Command\ArgumentTypes\CommandArgumentType
    {
        $reflection = new \ReflectionClass($node);
        $typeProperty = $reflection->getProperty('type');
        $typeProperty->setAccessible(true);
        return $typeProperty->getValue($node);
    }

    /**
     * Trouve le nœud racine correspondant au nom de commande
     */
    private function findRootCommand(string $commandName): ?CommandNode
    {
        foreach ($this->commands as $command) {
            $root = $command->getRoot();
            if ($root instanceof LiteralNode && $this->getNodeName($root) === $commandName) {
                return $root;
            }
        }
        return null;
    }

    /**
     * Trouve un nœud enfant correspondant à l'argument donné
     */
    private function findMatchingChild(CommandNode $parent, string $arg): ?CommandNode
    {
        $children = $this->getNodeChildren($parent);

        foreach ($children as $child) {
            if ($child instanceof LiteralNode && $this->getNodeName($child) === $arg) {
                return $child;
            }
            if ($child instanceof ArgumentNode) {
                // Pour les ArgumentNode, on considère qu'ils matchent toujours
                // (la validation du type d'argument se fait dans parseArgument)
                return $child;
            }
        }

        return null;
    }
}