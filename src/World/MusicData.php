<?php

namespace SnapMine\World;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class MusicData implements NbtSerializable
{
    #[NbtTag(IntTag::class, 'max_delay')]
    private int $maxDelay;

    #[NbtTag(IntTag::class, 'min_delay')]
    private int $minDelay;

    #[NbtTag(ByteTag::class, 'replace_current_music')]
    private bool $replaceCurrentMusic;

    #[NbtTag(StringTag::class)]
    private string $sound;
}