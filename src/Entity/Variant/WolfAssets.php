<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class WolfAssets implements NbtSerializable
{
    #[NbtTag(StringTag::class)]
    private string $angry = '';

    #[NbtTag(StringTag::class)]
    private string $tame = '';

    #[NbtTag(StringTag::class)]
    private string $wild = '';
}