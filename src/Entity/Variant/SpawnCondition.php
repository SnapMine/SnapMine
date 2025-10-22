<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class SpawnCondition implements NbtSerializable
{
    #[NbtTag(StringTag::class)]
    private string $type;

    #[NbtTag(StringTag::class)]
    private ?string $biome = null;

    #[NbtTag(FloatTag::class)]
    private ?float $min = null;

    #[NbtTag(StringTag::class)]
    private ?string $rangeKey = null;

    public function __construct(string $type, ?float $min = null, ?string $rangeKey = null)
    {
        $this->type = $type;
        $this->min = $min;
        $this->rangeKey = $rangeKey;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return float|null
     */
    public function getMin(): ?float
    {
        return $this->min;
    }

    /**
     * @return string|null
     */
    public function getRangeKey(): ?string
    {
        return $this->rangeKey;
    }

    /**
     * @return string|null
     */
    public function getBiome(): ?string
    {
        return $this->biome;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setBiome(?string $biome): void
    {
        $this->biome = $biome;
    }

    public function setMin(?float $min): void
    {
        $this->min = $min;
    }

    public function setRangeKey(?string $rangeKey): void
    {
        $this->rangeKey = $rangeKey;
    }
}