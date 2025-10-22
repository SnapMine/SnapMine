<?php

namespace SnapMine\World;

use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\IntTag;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class BiomeEffects implements NbtSerializable
{
    #[NbtTag(IntTag::class, 'fog_color')]
    private int $fogColor;

    #[NbtTag(FloatTag::class, 'music_volume')]
    private float $musicVolume;

    #[NbtTag(IntTag::class, 'sky_color')]
    private int $skyColor;

    #[NbtTag(IntTag::class, 'water_color')]
    private int $waterColor;

    #[NbtTag(IntTag::class, 'water_fog_color')]
    private int $waterFogColor;

    #[NbtCompound('mood_sound')]
    private BiomeMoodSound $moodSound;

    #[NbtList('music', Music::class, true)]
    private array $music;
}