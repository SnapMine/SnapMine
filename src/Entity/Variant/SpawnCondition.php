<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

readonly class SpawnCondition implements NbtSerializable
{
    #[NbtTag(StringTag::class)]
    private string $type;

    #[NbtTag(FloatTag::class)]
    private ?float $min;

    #[NbtTag(StringTag::class)]
    private ?string $rangeKey;

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
}