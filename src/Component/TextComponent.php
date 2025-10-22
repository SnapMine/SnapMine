<?php

namespace SnapMine\Component;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use JsonSerializable;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Utils\DyeColor;

class TextComponent implements JsonSerializable, NbtSerializable
{
    #[NbtTag(StringTag::class)]
    private ?string $text = null;

    #[NbtTag(StringTag::class)]
    private ?string $translate = null;

    /** @var TextComponent[]|null */
    #[NbtList('extra', TextComponent::class, true)]
    private ?array $children = null;

    #[NbtTag(StringTag::class)]
    private ?string $color = null;

    #[NbtTag(StringTag::class)]
    private ?string $font = null;

    #[NbtTag(ByteTag::class)]
    private ?bool $bold = null;

    #[NbtTag(ByteTag::class)]
    private ?bool $italic = null;

    #[NbtTag(ByteTag::class)]
    private ?bool $underline = null;

    #[NbtTag(ByteTag::class)]
    private ?bool $strike = null;

    #[NbtTag(ByteTag::class)]
    private ?bool $obfuscated = null;

    #[NbtTag(IntTag::class)]
    private ?int $shadowColor = null;

    public function __construct(
        TextComponentType $type = TextComponentType::TEXT,
        array $options = [],
    ) {
        switch ($type) {
            case TextComponentType::TEXT:
                $this->text = $options['text'];
                break;
            case TextComponentType::TRANSLATABLE:
                $this->translate = $options['translate'];
                // ...
                break;
        }
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

        // TODO : Add text, translation, ...

        return array_filter($data, fn ($item) => $item !== null);
    }
}