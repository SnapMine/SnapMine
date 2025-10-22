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

    public function getBlockSearchExtent(): int
    {
        return $this->blockSearchExtent;
    }

    public function setBlockSearchExtent(int $blockSearchExtent): void
    {
        $this->blockSearchExtent = $blockSearchExtent;
    }

    public function getOffset(): float
    {
        return $this->offset;
    }

    public function setOffset(float $offset): void
    {
        $this->offset = $offset;
    }

    public function getSound(): string
    {
        return $this->sound;
    }

    public function setSound(string $sound): void
    {
        $this->sound = $sound;
    }

    public function getTickDelay(): int
    {
        return $this->tickDelay;
    }

    public function setTickDelay(int $tickDelay): void
    {
        $this->tickDelay = $tickDelay;
    }
}