<?php

namespace SnapMine\Command;

use ReflectionClass;
use ReflectionMethod;
use SnapMine\Command\Attributes\Argument;
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

    function build(): array
    {
        $root = new CommandNode(CommandNode::TYPE_ROOT, '');
        $cmds = [];

        foreach ($this->commands as $fqcn) {
            $rc = new ReflectionClass($fqcn);

            // Cherche #[Command('name')]
            $cmdAttr = $rc->getAttributes(Command::class)[0] ?? null;
            if (!$cmdAttr || !$cmdAttr->getArguments()[0]) {
                continue;
            }

            $cmdName = $cmdAttr->getArguments()[0];
            $baseCommand = new CommandNode(CommandNode::TYPE_LITERAL, $cmdName);
            $cmds[] = $baseCommand;
            $root->addChild(count($cmds));

            foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                $methodAttrs = $method->getAttributes(SubCommand::class);


                if (count($methodAttrs) > 0) {
                    if (count($methodAttrs[0]->getArguments()) > 0) {
                        $subCmdName = $methodAttrs[0]->getArguments()[0];
                    } else {
                        continue;
                    }

                    $cmds[] = new CommandNode(CommandNode::TYPE_LITERAL, $subCmdName);
                    $baseCommand->addChild(count($cmds));
                }

            }


        }

        return [$root, ...$cmds];
    }
}