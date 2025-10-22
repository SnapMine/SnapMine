<?php

namespace SnapMine\World;

use Aternos\Nbt\Tag\IntTag;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class Music implements NbtSerializable
{
    #[NbtCompound('data')]
    private MusicData $data;

    #[NbtTag(IntTag::class)]
    private int $weight = 0;
}