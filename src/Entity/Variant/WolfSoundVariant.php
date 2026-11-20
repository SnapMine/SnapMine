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
 * @extends RegistryData<WolfSoundVariant>
 */
final class WolfSoundVariant extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly string $ambientSound,
        private readonly string $deathSound,
        private readonly string $growlSound,
        private readonly string $hurtSound,
        private readonly string $pantSound,
        private readonly string $whineSound,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('ambient_sound', Codecs::string(), fn (self $v) => $v->ambientSound),
            Field::required('death_sound', Codecs::string(), fn (self $v) => $v->deathSound),
            Field::required('growl_sound', Codecs::string(), fn (self $v) => $v->growlSound),
            Field::required('hurt_sound', Codecs::string(), fn (self $v) => $v->hurtSound),
            Field::required('pant_sound', Codecs::string(), fn (self $v) => $v->pantSound),
            Field::required('whine_sound', Codecs::string(), fn (self $v) => $v->whineSound),
        );
    }

    public function getAmbientSound(): string
    {
        return $this->ambientSound;
    }

    public function getDeathSound(): string
    {
        return $this->deathSound;
    }

    public function getGrowlSound(): string
    {
        return $this->growlSound;
    }

    public function getHurtSound(): string
    {
        return $this->hurtSound;
    }

    public function getPantSound(): string
    {
        return $this->pantSound;
    }

    public function getWhineSound(): string
    {
        return $this->whineSound;
    }
}
