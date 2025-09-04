<?php

namespace SnapMine\Command\Nodes;

use Closure;
use InvalidArgumentException;
use SnapMine\Command\ArgumentTypes\CommandArgumentType;
use SnapMine\Command\Command;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;
use SnapMine\Utils\Flags;

class CommandNode implements ProtocolEncodable
{
    use Flags;

    const FLAG_TYPE_LITERAL = 0x1;
    const FLAG_TYPE_ARGUMENT = 0x2;
    const FLAG_IS_EXECUTABLE = 0x4;
    const FLAG_HAS_REDIRECT = 0x8;
    const FLAG_HAS_SUGGESTIONS_TYPE = 0x10;
    const FLAG_IS_RESTRICTED = 0x20;


    /** @var CommandNode[] */
    protected array $children = [];
    protected int $index;


    public function __construct(
        protected CommandNode|Command $parent,
        protected ?Closure            $executor,
        protected int                 &$baseIndex
    )
    {
        if($this->executor !== null){
            $this->setFlag(self::FLAG_IS_EXECUTABLE, true);
        }

        $this->index = $baseIndex++;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    public function isExecutable(): bool
    {
        return $this->hasFlag(self::FLAG_IS_EXECUTABLE);
    }

    public function getExecutor(): ?Closure
    {
        return $this->executor;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function literal(string $name, ?callable $executor = null): LiteralNode
    {

        $literal = new LiteralNode($this, $this->baseIndex, $name, $executor);
        $this->children[] = $literal;

        return $literal;
    }

    /**
     * @param array<string, CommandArgumentType> $args
     */
    public function arguments(array $args, ?callable $executor = null): ArgumentNode
    {
        if (empty($args)) {
            throw new InvalidArgumentException("At least one argument is required");
        }

        $name = array_key_first($args);
        $element = array_shift($args);

        if (count($args) === 0) {
            return $this->argument($name, $element, $executor);
        }

        return $this->argument($name, $element)->arguments($args, $executor);
    }

    public function argument(string $name, CommandArgumentType $type, ?callable $executor = null): ArgumentNode
    {
        $newArg = new ArgumentNode($this, $this->baseIndex, $name, $type, $executor);
        $this->children[] = $newArg;

        return $newArg;
    }

    public function group(callable $group): self
    {
        $group($this);

        return $this;
    }

    public function build(): Command
    {
        if ($this->parent instanceof Command) {
            return $this->parent->build();
        }

        return $this->parent->build();
    }

    public function getAllNodes(): array
    {
        $nodes = [$this];

        foreach ($this->children as $child) {
            $nodes = array_merge($nodes, $child->getAllNodes());
        }

        return $nodes;
    }

    protected function encodeProperties(PacketSerializer $serializer): void
    {
    }

    public function encode(PacketSerializer $serializer): void
    {
        $serializer->putByte($this->flags)->putVarInt(count($this->children));
        foreach ($this->children as $child) {
            $serializer->putVarInt($child->index);
        }
//        if ($this->hasFlag(self::FLAG_HAS_REDIRECT) && $this->redirect !== null) {
//            $serializer->putVarInt($this->index);
//        }

        $this->encodeProperties($serializer);

//        if ($this->hasFlag(self::FLAG_HAS_SUGGESTIONS_TYPE) && $this->suggestions !== null) {
//            $serializer->putString($this->suggestions);
//        }
    }
}