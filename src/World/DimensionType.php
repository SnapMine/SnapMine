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
}