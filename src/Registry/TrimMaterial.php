<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Component\TextComponent;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

/**
 * @method static TrimMaterial AMETHYST()
 * @method static TrimMaterial COPPER()
 * @method static TrimMaterial DIAMOND()
 * @method static TrimMaterial EMERALD()
 * @method static TrimMaterial GOLD()
 * @method static TrimMaterial IRON()
 * @method static TrimMaterial LAPIS()
 * @method static TrimMaterial NETHERITE()
 * @method static TrimMaterial QUARTZ()
 * @method static TrimMaterial REDSTONE()
 * @method static TrimMaterial RESIN()
 */
class TrimMaterial extends RegistryData implements NbtSerializable
{
    #[NbtTag(StringTag::class, 'asset_name')]
    private string $assetName;

    #[NbtCompound('description')]
    private TextComponent $description;
}