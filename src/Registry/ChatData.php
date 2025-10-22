<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Component\TextComponent;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class ChatData implements NbtSerializable
{
    #[NbtTag(StringTag::class, 'translation_key')]
    private string $translationKey;

    #[NbtList('parameters', 'string')]
    private array $parameters;

    #[NbtCompound('style')]
    private ?TextComponent $style = null;

    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return $this->translationKey;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return TextComponent|null
     */
    public function getStyle(): ?TextComponent
    {
        return $this->style;
    }

    public function setTranslationKey(string $translationKey): void
    {
        $this->translationKey = $translationKey;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function setStyle(?TextComponent $style): void
    {
        $this->style = $style;
    }
}