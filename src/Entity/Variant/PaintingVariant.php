<?php

declare(strict_types=1);

namespace SnapMine\Entity\Variant;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
use SnapMine\Component\TextComponent;
use SnapMine\Registry\RegistryData;

/**
 * @extends RegistryData<PaintingVariant>
 */
final class PaintingVariant extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly string $assetId,
        private readonly int $height,
        private readonly int $width,
        private readonly TextComponent $title,
        private readonly ?TextComponent $author = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('asset_id', Codecs::string(), fn (self $v) => $v->assetId),
            Field::required('height', Codecs::int(), fn (self $v) => $v->height),
            Field::required('width', Codecs::int(), fn (self $v) => $v->width),
            Field::required('title', TextComponent::codec(), fn (self $v) => $v->title),
            Field::optional('author', TextComponent::codec(), fn (self $v) => $v->author),
        );
    }

    public function getAssetId(): string
    {
        return $this->assetId;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getTitle(): TextComponent
    {
        return $this->title;
    }

    public function getAuthor(): ?TextComponent
    {
        return $this->author;
    }
}
