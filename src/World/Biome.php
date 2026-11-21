<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
use SnapMine\Registry\RegistryData;

/**
 * @extends RegistryData<Biome>
 *
 * @method static Biome BADLANDS()
 * @method static Biome BAMBOO_JUNGLE()
 * @method static Biome BASALT_DELTAS()
 * @method static Biome BEACH()
 * @method static Biome BIRCH_FOREST()
 */
final class Biome extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly bool $hasPrecipitation,
        private readonly float $temperature,
        private readonly float $downfall,
        private readonly BiomeEffects $effects,
        private readonly string|array $carvers,
        private readonly array $features,
        private readonly array $spawners,
        private readonly array $spawnCosts,
        private readonly ?float $creatureSpawnProbability = null,
        private readonly ?string $temperatureModifier = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('has_precipitation', Codecs::bool(), fn (self $b) => $b->hasPrecipitation),
            Field::required('temperature', Codecs::float(), fn (self $b) => $b->temperature),
            Field::required('downfall', Codecs::float(), fn (self $b) => $b->downfall),
            Field::required('effects', BiomeEffects::codec(), fn (self $b) => $b->effects),
            Field::required(
                'carvers',
                Codecs::either(Codecs::string(), Codecs::listOf(Codecs::string())),
                fn (self $b) => $b->carvers,
            ),
            Field::required('features', Codecs::listOf(Codecs::listOf(Codecs::string())), fn (self $b) => $b->features),
            Field::required('spawners', Codecs::mapOf(Codecs::listOf(SpawnerEntry::codec())), fn (self $b) => $b->spawners),
            Field::required('spawn_costs', Codecs::mapOf(SpawnCost::codec()), fn (self $b) => $b->spawnCosts),
            Field::optional('creature_spawn_probability', Codecs::float(), fn (self $b) => $b->creatureSpawnProbability),
            Field::optional('temperature_modifier', Codecs::string(), fn (self $b) => $b->temperatureModifier),
        );
    }

    public function isHasPrecipitation(): bool
    {
        return $this->hasPrecipitation;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getDownfall(): float
    {
        return $this->downfall;
    }

    public function getEffects(): BiomeEffects
    {
        return $this->effects;
    }

    public function getCarvers(): string|array
    {
        return $this->carvers;
    }

    /**
     * @return string[][]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    /**
     * @return array<string, SpawnerEntry[]>
     */
    public function getSpawners(): array
    {
        return $this->spawners;
    }

    /**
     * @return array<string, SpawnCost>
     */
    public function getSpawnCosts(): array
    {
        return $this->spawnCosts;
    }

    public function getCreatureSpawnProbability(): ?float
    {
        return $this->creatureSpawnProbability;
    }

    public function getTemperatureModifier(): ?string
    {
        return $this->temperatureModifier;
    }
}
