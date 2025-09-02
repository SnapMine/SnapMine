<?php

namespace SnapMine\Command;

class CommandNode
{
    const TYPE_ROOT = 0;
    const TYPE_LITERAL = 1;
    const TYPE_ARGUMENT = 2;

    private array $children = [];
    private ?int $redirect = null;
    private ?string $parser = null;
    private array $properties = [];
    private ?string $suggestions = null;
    private bool $isExecutable = false;  // 0x04
    private bool $isRestricted = false;  // 0x20

    public function __construct(
        private readonly int $type,
        private readonly string $name
    )
    {
    }

    public function addChild(int $index): void
    {
        $this->children[] = $index;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return string|null
     */
    public function getParser(): ?string
    {
        return $this->parser;
    }

    /**
     * @param string|null $parser
     */
    public function setParser(?string $parser): void
    {
        $this->parser = $parser;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @return int|null
     */
    public function getRedirect(): ?int
    {
        return $this->redirect;
    }

    /**
     * @param int|null $redirect
     */
    public function setRedirect(?int $redirect): void
    {
        $this->redirect = $redirect;
    }

    /**
     * @return string|null
     */
    public function getSuggestions(): ?string
    {
        return $this->suggestions;
    }

    /**
     * @param string|null $suggestions
     */
    public function setSuggestions(?string $suggestions): void
    {
        $this->suggestions = $suggestions;
    }

    /**
     * @param bool $isExecutable
     */
    public function setExecutable(bool $isExecutable): void
    {
        $this->isExecutable = $isExecutable;
    }

    /**
     * @return bool
     */
    public function isExecutable(): bool
    {
        return $this->isExecutable;
    }

    public function computeFlags(): int
    {
        $flags = ($this->type & 0x03);
        if ($this->isExecutable) $flags |= 0x04;
        if ($this->redirect !== null) $flags |= 0x08;

//        if ($this->type === self::TYPE_ARGUMENT && $this->suggestionsType !== null) $flags |= 0x10;
        if ($this->isRestricted) $flags |= 0x20;

        return $flags & 0xFF;
    }
}