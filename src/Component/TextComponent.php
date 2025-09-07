<?php

namespace SnapMine\Component;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use JsonSerializable;
use SnapMine\Registry\EncodableToNbt;
use SnapMine\Utils\DyeColor;

class TextComponent implements JsonSerializable, EncodableToNbt
{
    /** @var TextComponent[] */
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

    public function toNBT(): CompoundTag
    {
        $tag = new CompoundTag();

        $tag->set('text', (new StringTag())->setValue($this->options['text']));

        if (! is_null($this->color))
            $tag->set('color', (new StringTag())->setValue($this->color));

        if (! is_null($this->font))
            $tag->set('font', (new StringTag())->setValue($this->font));

        $tag->set('bold', (new ByteTag())->setValue($this->bold));
        $tag->set('underlined', (new ByteTag())->setValue($this->underline));
        $tag->set('italic', (new ByteTag())->setValue($this->italic));
        $tag->set('strikethrough', (new ByteTag())->setValue($this->strike));
        $tag->set('obfuscated', (new ByteTag())->setValue($this->obfuscated));

        $tag->set('shadow_color', (new IntTag())->setValue($this->shadowColor));

        if (count($this->children) > 0) {
            $childrenTag = new ListTag();

            foreach ($this->children as $child) {
                $childrenTag[] = $child->toNBT();
            }

            $tag->set('extra', $childrenTag);
        }

        return $tag;
    }
}