<?php

namespace SnapMine\World;

use Aternos\Nbt\Tag\DoubleTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class BiomeMoodSound implements NbtSerializable
{
    #[NbtTag(IntTag::class, 'block_search_extent')]
    private int $blockSearchExtent;

    #[NbtTag(DoubleTag::class)]
    private float $offset;

    #[NbtTag(StringTag::class)]
    private string $sound;

    #[NbtTag(IntTag::class, 'tick_delay')]
    private int $tickDelay;
}