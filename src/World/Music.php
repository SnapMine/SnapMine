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

    public function getData(): MusicData
    {
        return $this->data;
    }

    public function setData(MusicData $data): void
    {
        $this->data = $data;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }


}