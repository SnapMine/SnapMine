<?php

declare(strict_types=1);

namespace SnapMine\Registry;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
use SnapMine\Component\TextComponent;

final class ChatData implements CodecProvider
{
    public function __construct(
        private readonly string $translationKey,
        private readonly array $parameters,
        private readonly ?TextComponent $style = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('translation_key', Codecs::string(), fn (self $d) => $d->translationKey),
            Field::required('parameters', Codecs::listOf(Codecs::string()), fn (self $d) => $d->parameters),
            Field::optional('style', TextComponent::codec(), fn (self $d) => $d->style),
        );
    }

    public function getTranslationKey(): string
    {
        return $this->translationKey;
    }

    /**
     * @return string[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getStyle(): ?TextComponent
    {
        return $this->style;
    }
}
