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
}