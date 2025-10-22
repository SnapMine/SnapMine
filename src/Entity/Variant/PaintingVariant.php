<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Component\TextComponent;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

class PaintingVariant extends RegistryData implements NbtSerializable
{
    #[NbtTag(StringTag::class, 'asset_id')]
    private string $assetId;

    #[NbtTag(IntTag::class, 'height')]
    private int $height;

    #[NbtTag(IntTag::class, 'width')]
    private int $width;

    #[NbtCompound('author')]
    private ?TextComponent $author = null;

    #[NbtCompound('title')]
    private TextComponent $title;
}