<?php

declare(strict_types=1);

namespace SnapMine\Entity\Variant;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
use SnapMine\Registry\RegistryData;

/**
 * @extends RegistryData<WolfVariant>
 *
 * @method static WolfVariant ASHEN()
 * @method static WolfVariant BLACK()
 * @method static WolfVariant CHESTNUT()
 * @method static WolfVariant PALE()
 * @method static WolfVariant RUSTY()
 * @method static WolfVariant SNOWY()
 * @method static WolfVariant WOODS()
 */
final class WolfVariant extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly WolfAssets $assets,
        private readonly array $spawnConditions,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('assets', WolfAssets::codec(), fn (self $v) => $v->assets),
            Field::required('spawn_conditions', Codecs::listOf(SpawnConditions::codec()), fn (self $v) => $v->spawnConditions),
        );
    }

    public function getAssets(): WolfAssets
    {
        return $this->assets;
    }

    /**
     * @return SpawnConditions[]
     */
    public function getSpawnConditions(): array
    {
        return $this->spawnConditions;
    }
}
