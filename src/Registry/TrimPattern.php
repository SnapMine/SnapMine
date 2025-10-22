<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Component\TextComponent;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

/**
 * @method static TrimPattern BOLT()
 * @method static TrimPattern COAST()
 * @method static TrimPattern DUNE()
 * @method static TrimPattern EYE()
 * @method static TrimPattern FLOW()
 * @method static TrimPattern HOST()
 * @method static TrimPattern RAISER()
 * @method static TrimPattern RIB()
 * @method static TrimPattern SENTRY()
 * @method static TrimPattern SHAPER()
 * @method static TrimPattern SILENCE()
 * @method static TrimPattern SNOUT()
 * @method static TrimPattern SPIRE()
 * @method static TrimPattern TIDE()
 * @method static TrimPattern VEX()
 * @method static TrimPattern WARD()
 * @method static TrimPattern WAYFINDER()
 * @method static TrimPattern WILD()
 */
class TrimPattern extends RegistryData implements NbtSerializable
{
    #[NbtTag(StringTag::class, 'asset_id')]
    private string $assetId;

    #[NbtTag(ByteTag::class)]
    private int $decal;

    #[NbtCompound('description')]
    private TextComponent $description;

    /**
     * @return string
     */
    public function getAssetId(): string
    {
        return $this->assetId;
    }

    /**
     * @return int
     */
    public function getDecal(): int
    {
        return $this->decal;
    }

    /**
     * @return TextComponent
     */
    public function getDescription(): TextComponent
    {
        return $this->description;
    }

    public function setAssetId(string $assetId): void
    {
        $this->assetId = $assetId;
    }

    public function setDecal(int $decal): void
    {
        $this->decal = $decal;
    }

    public function setDescription(TextComponent $description): void
    {
        $this->description = $description;
    }
}