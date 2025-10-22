<?php

namespace SnapMine\World;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

class DimensionType extends RegistryData implements NbtSerializable
{
    #[NbtTag(FloatTag::class, 'ambient_light')]
    private float $ambientLight;

    #[NbtTag(ByteTag::class, 'bed_works')]
    private bool $bedWorks;

    #[NbtTag(FloatTag::class, 'coordinate_scale')]
    private float $coordinateScale;

    #[NbtTag(StringTag::class)]
    private string $effects;

    #[NbtTag(ByteTag::class, 'has_ceiling')]
    private bool $hasCeiling;

    #[NbtTag(ByteTag::class, 'has_raids')]
    private bool $hasRaids;

    #[NbtTag(ByteTag::class, 'has_skylight')]
    private bool $hasSkylight;

    #[NbtTag(IntTag::class)]
    private int $height;

    #[NbtTag(StringTag::class)]
    private string $infiniburn;

    #[NbtTag(IntTag::class, 'logical_height')]
    private int $logicalHeight;

    #[NbtTag(IntTag::class, 'min_y')]
    private int $minY;

    #[NbtTag(IntTag::class, 'monster_spawn_block_light_limit')]
    private int $monsterSpawnBlockLightLimit;

    #[NbtTag(ByteTag::class)]
    private bool $natural;

    #[NbtTag(ByteTag::class, 'piglin_safe')]
    private bool $piglinSafe;

    #[NbtTag(ByteTag::class, 'respawn_anchor_works')]
    private bool $respawnAnchorWorks;

    #[NbtTag(ByteTag::class)]
    private bool $ultrawarm;

    #[NbtTag(IntTag::class, 'monster_spawn_light_level')]
    #[NbtCompound('monster_spawn_light_level')]
    private MonsterSpawnLightLevel|int $monsterSpawnLightLevel;

    #[NbtTag(IntTag::class, 'fixed_time')]
    private ?int $fixedTime = null;

    public function getAmbientLight(): float
    {
        return $this->ambientLight;
    }

    public function setAmbientLight(float $ambientLight): void
    {
        $this->ambientLight = $ambientLight;
    }

    public function isBedWorks(): bool
    {
        return $this->bedWorks;
    }

    public function setBedWorks(bool $bedWorks): void
    {
        $this->bedWorks = $bedWorks;
    }

    public function getCoordinateScale(): float
    {
        return $this->coordinateScale;
    }

    public function setCoordinateScale(float $coordinateScale): void
    {
        $this->coordinateScale = $coordinateScale;
    }

    public function getEffects(): string
    {
        return $this->effects;
    }

    public function setEffects(string $effects): void
    {
        $this->effects = $effects;
    }

    public function isHasCeiling(): bool
    {
        return $this->hasCeiling;
    }

    public function setHasCeiling(bool $hasCeiling): void
    {
        $this->hasCeiling = $hasCeiling;
    }

    public function isHasRaids(): bool
    {
        return $this->hasRaids;
    }

    public function setHasRaids(bool $hasRaids): void
    {
        $this->hasRaids = $hasRaids;
    }

    public function isHasSkylight(): bool
    {
        return $this->hasSkylight;
    }

    public function setHasSkylight(bool $hasSkylight): void
    {
        $this->hasSkylight = $hasSkylight;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getInfiniburn(): string
    {
        return $this->infiniburn;
    }

    public function setInfiniburn(string $infiniburn): void
    {
        $this->infiniburn = $infiniburn;
    }

    public function getLogicalHeight(): int
    {
        return $this->logicalHeight;
    }

    public function setLogicalHeight(int $logicalHeight): void
    {
        $this->logicalHeight = $logicalHeight;
    }

    public function getMinY(): int
    {
        return $this->minY;
    }

    public function setMinY(int $minY): void
    {
        $this->minY = $minY;
    }

    public function getMonsterSpawnBlockLightLimit(): int
    {
        return $this->monsterSpawnBlockLightLimit;
    }

    public function setMonsterSpawnBlockLightLimit(int $monsterSpawnBlockLightLimit): void
    {
        $this->monsterSpawnBlockLightLimit = $monsterSpawnBlockLightLimit;
    }

    public function isNatural(): bool
    {
        return $this->natural;
    }

    public function setNatural(bool $natural): void
    {
        $this->natural = $natural;
    }

    public function isPiglinSafe(): bool
    {
        return $this->piglinSafe;
    }

    public function setPiglinSafe(bool $piglinSafe): void
    {
        $this->piglinSafe = $piglinSafe;
    }

    public function isRespawnAnchorWorks(): bool
    {
        return $this->respawnAnchorWorks;
    }

    public function setRespawnAnchorWorks(bool $respawnAnchorWorks): void
    {
        $this->respawnAnchorWorks = $respawnAnchorWorks;
    }

    public function isUltrawarm(): bool
    {
        return $this->ultrawarm;
    }

    public function setUltrawarm(bool $ultrawarm): void
    {
        $this->ultrawarm = $ultrawarm;
    }

    public function getMonsterSpawnLightLevel(): MonsterSpawnLightLevel|int
    {
        return $this->monsterSpawnLightLevel;
    }

    public function setMonsterSpawnLightLevel(MonsterSpawnLightLevel|int $monsterSpawnLightLevel): void
    {
        $this->monsterSpawnLightLevel = $monsterSpawnLightLevel;
    }

    public function getFixedTime(): ?int
    {
        return $this->fixedTime;
    }

    public function setFixedTime(?int $fixedTime): void
    {
        $this->fixedTime = $fixedTime;
    }
}