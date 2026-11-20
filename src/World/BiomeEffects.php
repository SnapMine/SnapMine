<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

final class BiomeEffects implements CodecProvider
{
    public function __construct(
        private readonly int $fogColor,
        private readonly int $skyColor,
        private readonly int $waterColor,
        private readonly int $waterFogColor,
        private readonly ?float $musicVolume = null,
        private readonly ?array $music = null,
        private readonly ?BiomeMoodSound $moodSound = null,
        private readonly ?string $grassColorModifier = null,
        private readonly ?int $grassColor = null,
        private readonly ?int $foliageColor = null,
        private readonly ?int $dryFoliageColor = null,
        private readonly ?BiomeParticle $particle = null,
        private readonly ?string $ambientSound = null,
        private readonly ?AmbientSound $additionsSound = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('fog_color', Codecs::int(), fn (self $e) => $e->fogColor),
            Field::required('sky_color', Codecs::int(), fn (self $e) => $e->skyColor),
            Field::required('water_color', Codecs::int(), fn (self $e) => $e->waterColor),
            Field::required('water_fog_color', Codecs::int(), fn (self $e) => $e->waterFogColor),
            Field::optional('music_volume', Codecs::float(), fn (self $e) => $e->musicVolume),
            Field::optional('music', Codecs::listOf(Music::codec()), fn (self $e) => $e->music),
            Field::optional('mood_sound', BiomeMoodSound::codec(), fn (self $e) => $e->moodSound),
            Field::optional('grass_color_modifier', Codecs::string(), fn (self $e) => $e->grassColorModifier),
            Field::optional('grass_color', Codecs::int(), fn (self $e) => $e->grassColor),
            Field::optional('foliage_color', Codecs::int(), fn (self $e) => $e->foliageColor),
            Field::optional('dry_foliage_color', Codecs::int(), fn (self $e) => $e->dryFoliageColor),
            Field::optional('particle', BiomeParticle::codec(), fn (self $e) => $e->particle),
            Field::optional('ambient_sound', Codecs::string(), fn (self $e) => $e->ambientSound),
            Field::optional('additions_sound', AmbientSound::codec(), fn (self $e) => $e->additionsSound),
        );
    }

    public function getFogColor(): int
    {
        return $this->fogColor;
    }

    public function getSkyColor(): int
    {
        return $this->skyColor;
    }

    public function getWaterColor(): int
    {
        return $this->waterColor;
    }

    public function getWaterFogColor(): int
    {
        return $this->waterFogColor;
    }

    public function getMusicVolume(): ?float
    {
        return $this->musicVolume;
    }

    /**
     * @return Music[]|null
     */
    public function getMusic(): ?array
    {
        return $this->music;
    }

    public function getMoodSound(): ?BiomeMoodSound
    {
        return $this->moodSound;
    }

    public function getGrassColorModifier(): ?string
    {
        return $this->grassColorModifier;
    }

    public function getGrassColor(): ?int
    {
        return $this->grassColor;
    }

    public function getFoliageColor(): ?int
    {
        return $this->foliageColor;
    }

    public function getDryFoliageColor(): ?int
    {
        return $this->dryFoliageColor;
    }

    public function getParticle(): ?BiomeParticle
    {
        return $this->particle;
    }

    public function getAmbientSound(): ?string
    {
        return $this->ambientSound;
    }

    public function getAdditionsSound(): ?AmbientSound
    {
        return $this->additionsSound;
    }
}
