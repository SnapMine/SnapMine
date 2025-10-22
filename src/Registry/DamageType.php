<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

/**
 * @extends RegistryData<DamageType>
 */
class DamageType extends RegistryData implements NbtSerializable
{
    #[NbtTag(FloatTag::class)]
    private float $exhaustion = 0.0;

    #[NbtTag(StringTag::class, 'message_id')]
    private string $messageId;

    #[NbtTag(StringTag::class)]
    private string $scaling;

    #[NbtTag(StringTag::class)]
    private ?string $effects = null;

    #[NbtTag(StringTag::class, 'death_message_type')]
    private ?string $deathMessageType = null;

    /**
     * @return float
     */
    public function getExhaustion(): float
    {
        return $this->exhaustion;
    }

    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @return string|null
     */
    public function getEffects(): ?string
    {
        return $this->effects;
    }

    /**
     * @return string|null
     */
    public function getDeathMessageType(): ?string
    {
        return $this->deathMessageType;
    }

    /**
     * @return string
     */
    public function getScaling(): string
    {
        return $this->scaling;
    }
}