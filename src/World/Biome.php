<?php

namespace SnapMine\World;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

class Biome extends RegistryData implements NbtSerializable
{
    #[NbtTag(FloatTag::class)]
    private float $downfall = 0.0;

    #[NbtTag(ByteTag::class, 'has_precipitation')]
    private bool $hasPrecipitation = false;

    #[NbtTag(FloatTag::class)]
    private float $temperature = 0.0;

    #[NbtTag(StringTag::class)]
    #[NbtList('carvers', 'string')]
    private string|array $carvers;

    #[NbtCompound('effects')]
    private BiomeEffects $effects;

    /**
     * @return float
     */
    public function getDownfall(): float
    {
        return $this->downfall;
    }

    /**
     * @return bool
     */
    public function hasPrecipitation(): bool
    {
        return $this->hasPrecipitation;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @return array|string
     */
    public function getCarvers(): array|string
    {
        return $this->carvers;
    }

    /**
     * @return BiomeEffects
     */
    public function getEffects(): BiomeEffects
    {
        return $this->effects;
    }

    public function isHasPrecipitation(): bool
    {
        return $this->hasPrecipitation;
    }

    public function setHasPrecipitation(bool $hasPrecipitation): void
    {
        $this->hasPrecipitation = $hasPrecipitation;
    }
}