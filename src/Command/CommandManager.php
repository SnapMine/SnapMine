<?php

namespace SnapMine\Command;

class CommandManager
{
    /** @var array<string, CommandExecutor> */
    private array $commands = [];

    public function add(string $name, CommandExecutor $executor): void
    {
        $this->commands[$name] = $executor;
    }

    public function has(string $name): bool
    {
        return isset($this->commands[$name]);
    }

    public function get(string $name): CommandExecutor
    {
        return $this->commands[$name];
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @return CommandNode[]
     */
    public function build(): array
    {
        $root = new CommandNode(CommandNode::TYPE_ROOT);
        $nodes = [$root];

        $commands = array_keys($this->commands);
        for ($i = 0; $i < count($commands); $i++) {
            $nodes[] = new CommandNode(CommandNode::TYPE_LITERAL, $commands[$i]);

            $nodes[$i]->setExecutable(true);

            $root->addChild($i);
        }

        return $nodes;
    }
}