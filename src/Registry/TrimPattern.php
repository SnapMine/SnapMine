<?php

declare(strict_types=1);

namespace SnapMine\Registry;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
use SnapMine\Component\TextComponent;

/**
 * @method static TrimPattern BOLT()
 * @method static TrimPattern COAST()
 * @method static TrimPattern DUNE()
 * @method static TrimPattern EYE()
 * @method static TrimPattern FLOW()
 * @method static TrimPattern HOST()
 * @method static TrimPattern RAISER()
 * @method static TrimPattern SENTRY()
 * @method static TrimPattern SILENCE()
 * @method static TrimPattern SNOUT()
 * @method static TrimPattern SPIRE()
 * @method static TrimPattern TIDE()
 * @method static TrimPattern VEX()
 * @method static TrimPattern WAYFINDER()
 * @method static TrimPattern WARD()
 * @method static TrimPattern WILD()
 */
final class TrimPattern extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly string $assetId,
        private readonly bool $decal,
        private readonly TextComponent $description,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('asset_id', Codecs::string(), fn (self $p) => $p->assetId),
            Field::required('decal', Codecs::bool(), fn (self $p) => $p->decal),
            Field::required('description', TextComponent::codec(), fn (self $p) => $p->description),
        );
    }

    public function getAssetId(): string
    {
        return $this->assetId;
    }

    public function getDecal(): bool
    {
        return $this->decal;
    }

    public function getDescription(): TextComponent
    {
        return $this->description;
    }
}
