<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

class WolfSoundVariant extends RegistryData implements NbtSerializable
{
    #[NbtTag(StringTag::class, 'ambient_sound')]
    private string $ambientSound = '';

    #[NbtTag(StringTag::class, 'death_sound')]
    private string $deathSound = '';

    #[NbtTag(StringTag::class, 'growl_sound')]
    private string $growlSound = '';

    #[NbtTag(StringTag::class, 'hurt_sound')]
    private string $hurtSound = '';

    #[NbtTag(StringTag::class, 'pant_sound')]
    private string $pantSound = '';

    #[NbtTag(StringTag::class, 'whine_sound')]
    private string $whineSound = '';

    /**
     * @return string
     */
    public function getAmbientSound(): string
    {
        return $this->ambientSound;
    }

    /**
     * @return string
     */
    public function getDeathSound(): string
    {
        return $this->deathSound;
    }

    /**
     * @return string
     */
    public function getGrowlSound(): string
    {
        return $this->growlSound;
    }

    /**
     * @return string
     */
    public function getHurtSound(): string
    {
        return $this->hurtSound;
    }

    /**
     * @return string
     */
    public function getPantSound(): string
    {
        return $this->pantSound;
    }

    /**
     * @return string
     */
    public function getWhineSound(): string
    {
        return $this->whineSound;
    }
}