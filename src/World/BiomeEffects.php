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

    public function getFogColor(): int
    {
        return $this->fogColor;
    }

    public function setFogColor(int $fogColor): void
    {
        $this->fogColor = $fogColor;
    }

    public function getMusicVolume(): float
    {
        return $this->musicVolume;
    }

    public function setMusicVolume(float $musicVolume): void
    {
        $this->musicVolume = $musicVolume;
    }

    public function getSkyColor(): int
    {
        return $this->skyColor;
    }

    public function setSkyColor(int $skyColor): void
    {
        $this->skyColor = $skyColor;
    }

    public function getWaterColor(): int
    {
        return $this->waterColor;
    }

    public function setWaterColor(int $waterColor): void
    {
        $this->waterColor = $waterColor;
    }

    public function getWaterFogColor(): int
    {
        return $this->waterFogColor;
    }

    public function setWaterFogColor(int $waterFogColor): void
    {
        $this->waterFogColor = $waterFogColor;
    }

    public function getMoodSound(): BiomeMoodSound
    {
        return $this->moodSound;
    }

    public function setMoodSound(BiomeMoodSound $moodSound): void
    {
        $this->moodSound = $moodSound;
    }

    public function getMusic(): array
    {
        return $this->music;
    }

    public function setMusic(array $music): void
    {
        $this->music = $music;
    }
}