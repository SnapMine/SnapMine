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

    public function getMaxDelay(): int
    {
        return $this->maxDelay;
    }

    public function setMaxDelay(int $maxDelay): void
    {
        $this->maxDelay = $maxDelay;
    }

    public function getMinDelay(): int
    {
        return $this->minDelay;
    }

    public function setMinDelay(int $minDelay): void
    {
        $this->minDelay = $minDelay;
    }

    public function isReplaceCurrentMusic(): bool
    {
        return $this->replaceCurrentMusic;
    }

    public function setReplaceCurrentMusic(bool $replaceCurrentMusic): void
    {
        $this->replaceCurrentMusic = $replaceCurrentMusic;
    }

    public function getSound(): string
    {
        return $this->sound;
    }

    public function setSound(string $sound): void
    {
        $this->sound = $sound;
    }
}