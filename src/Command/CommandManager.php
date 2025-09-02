<?php

namespace SnapMine\Command;

use ReflectionClass;
use SnapMine\Command\Attributes\Command;
use SnapMine\Command\Attributes\SubCommand;

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

        foreach ($this->commands as $executor) {
            $reflectionClass = new ReflectionClass($executor);

            $commands = $reflectionClass->getAttributes(Command::class);

            if (count($commands) === 0) {
                throw new \Error("Class " . $reflectionClass->getName() . " is missing Command attribute");
            }

            $name = $commands[0]->getArguments()['name'];
            $subCommands = $reflectionClass->getAttributes(SubCommand::class);

            foreach ($subCommands as $subCommand) {
                $subCommand->newInstance()
            }
        }

        return [];
    }
}