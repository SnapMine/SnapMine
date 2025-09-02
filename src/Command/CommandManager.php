<?php

namespace SnapMine\Command;

class CommandManager
{
    /** @var array<object> */
    private array $commands = [];

    public function add(string $name, object $executor): void
    {
        $this->commands[$name] = $executor;
    }

    public function has(string $name): bool
    {
        return isset($this->commands[$name]);
    }

    public function get(string $name): object
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
        $root = new CommandNode(CommandNode::TYPE_ROOT, 'root');
        $index = 1;

        foreach ($this->commands as $name => $executor) {

        }

        return [];
    }
}