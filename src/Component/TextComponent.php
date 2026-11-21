<?php

declare(strict_types=1);

namespace SnapMine\Component;

use JsonSerializable;
use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
use SnapMine\Utils\DyeColor;

/**
 * A text component, serializable to JSON (chat) and NBT (packets) through a
 * single {@see TextComponent::codec() code declaration.
 *
 * The component stays mutable: the fluent builder methods ({@see append()},
 * {@see color()}, ...) mutate the instance, while the codec reads the current
 * state through getters.
 */
class TextComponent implements JsonSerializable, CodecProvider
{
    public function __construct(
        private ?string $text = null,
        private ?string $translate = null,
        private ?string $fallback = null,
        private ?array $with = null,
        private ?array $children = null,
        private ?string $color = null,
        private ?string $font = null,
        private ?bool $bold = null,
        private ?bool $italic = null,
        private ?bool $underline = null,
        private ?bool $strike = null,
        private ?bool $obfuscated = null,
        private ?int $shadowColor = null,
    ) {
    }

    /**
     * The single declaration used to decode AND encode a text component,
     * whatever the format (registry JSON, NBT of chat packets...).
     *
     * Key names follow the vanilla component format (underlined,
     * strikethrough, shadow_color).
     */
    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::optional('text', Codecs::string(), fn (self $t) => $t->text),
            Field::optional('translate', Codecs::string(), fn (self $t) => $t->translate),
            Field::optional('fallback', Codecs::string(), fn (self $t) => $t->fallback),
            Field::optional('with', Codecs::listOf(Codecs::either(Codecs::lazy(fn () => self::codec()), Codecs::string())), fn (self $t) => $t->with),
            Field::optional('extra', Codecs::listOf(Codecs::lazy(fn () => self::codec())), fn (self $t) => $t->children),
            Field::optional('color', Codecs::string(), fn (self $t) => $t->color),
            Field::optional('font', Codecs::string(), fn (self $t) => $t->font),
            Field::optional('bold', Codecs::bool(), fn (self $t) => $t->bold),
            Field::optional('italic', Codecs::bool(), fn (self $t) => $t->italic),
            Field::optional('underlined', Codecs::bool(), fn (self $t) => $t->underline),
            Field::optional('strikethrough', Codecs::bool(), fn (self $t) => $t->strike),
            Field::optional('obfuscated', Codecs::bool(), fn (self $t) => $t->obfuscated),
            Field::optional('shadow_color', Codecs::int(), fn (self $t) => $t->shadowColor),
        );
    }

    public static function text(string $text): self
    {
        return new self(text: $text);
    }

    public static function translatable(string $translate, ?string $fallback = null, ?array $with = null): self
    {
        return new self(translate: $translate, fallback: $fallback, with: $with);
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getTranslate(): ?string
    {
        return $this->translate;
    }

    public function getFallback(): ?string
    {
        return $this->fallback;
    }

    public function getWith(): ?array
    {
        return $this->with;
    }

    /**
     * @return TextComponent[]|null
     */
    public function getChildren(): ?array
    {
        return $this->children;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function isBold(): ?bool
    {
        return $this->bold;
    }

    public function isItalic(): ?bool
    {
        return $this->italic;
    }

    public function isUnderline(): ?bool
    {
        return $this->underline;
    }

    public function isStrike(): ?bool
    {
        return $this->strike;
    }

    public function isObfuscated(): ?bool
    {
        return $this->obfuscated;
    }

    public function getShadowColor(): ?int
    {
        return $this->shadowColor;
    }

    public function jsonSerialize(): array
    {
        $data = [
            "text" => $this->text,
            "translate" => $this->translate,
            "fallback" => $this->fallback,
            "with" => $this->with,
            "color" => $this->color,
            "font" => $this->font,
            "bold" => $this->bold,
            "italic" => $this->italic,
            "underlined" => $this->underline,
            "strikethrough" => $this->strike,
            "obfuscated" => $this->obfuscated,
            "shadow_color" => $this->shadowColor,
            "extra" => $this->children,
        ];

        return array_filter($data, fn ($item) => $item !== null);
    }
}
