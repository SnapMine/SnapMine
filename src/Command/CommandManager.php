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
}