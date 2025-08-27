<?php

namespace SnapMine\Component;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use JsonSerializable;
use SnapMine\Registry\EncodableToNbt;
use SnapMine\Utils\DyeColor;

class TextComponent implements JsonSerializable, EncodableToNbt
{
    private array $children = [];
    private ?string $color = null;
    private ?string $font = null;
    private bool $bold = false;
    private bool $italic = false;
    private bool $underline = false;
    private bool $strike = false;
    private bool $obfuscated = false;
    private int $shadowColor = 0;

    public function __construct(
        private readonly TextComponentType $type,
        private readonly array $options = [],
    ) {
    }

    public static function text(string $text): self
    {
        return new self(TextComponentType::TEXT, [
            "text" => $text,
        ]);
    }

    public static function translatable(string $translate, ?string $fallback = null, ?array $with = null): self
    {
        return new self(TextComponentType::TRANSLATABLE, [
            "translate" => $translate,
            "fallback" => $fallback,
            "with" => $with,
        ]);
    }

    public function append(TextComponent $text): self
    {
        $this->children[] = $text;

        return $this;
    }

    public function color(int|DyeColor $color): self
    {
        if (is_int($color)) {
            $this->color = "#" . dechex($color);
        } else {
            $this->color = strtolower($color->name);
        }

        return $this;
    }

    public function font(string|null $font): self
    {
        $this->font = $font;

        return $this;
    }

    public function bold(bool $bold): self
    {
        $this->bold = $bold;

        return $this;
    }

    public function italic(bool $italic): self
    {
        $this->italic = $italic;

        return $this;
    }

    public function underline(bool $underline): self
    {
        $this->underline = $underline;

        return $this;
    }

    public function strike(bool $strike): self
    {
        $this->strike = $strike;

        return $this;
    }

    public function obfuscated(bool $obfuscated): self
    {
        $this->obfuscated = $obfuscated;

        return $this;
    }

    public function shadowColor(int $r, int $g, int $b): self
    {
        $r = max(0, min(255, $r));
        $g = max(0, min(255, $g));
        $b = max(0, min(255, $b));

        $this->shadowColor = $r << 16 | $g << 8 | $b;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [
            "type" => strtolower($this->type->name),
            "color" => $this->color,
            "font" => $this->font,
            "bold" => $this->bold,
            "italic" => $this->italic,
            "underline" => $this->underline,
            "strike" => $this->strike,
            "obfuscated" => $this->obfuscated,
            "shadowColor" => $this->shadowColor,
            "extra" => $this->children,
        ];

        $data = array_merge($data, $this->options);

        return array_filter($data, fn ($item) => $item !== null);
    }

    public function toNBT(): StringTag|CompoundTag
    {
        $tag = new StringTag();

        $tag->setValue($this->options["text"]);

        return $tag;
    }
}