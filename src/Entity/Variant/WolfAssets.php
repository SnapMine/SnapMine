<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class WolfAssets implements NbtSerializable
{
    #[NbtTag(StringTag::class)]
    private string $angry;

    #[NbtTag(StringTag::class)]
    private string $tame;

    #[NbtTag(StringTag::class)]
    private string $wild;

    /**
     * @return string
     */
    public function getAngry(): string
    {
        return $this->angry;
    }

    /**
     * @return string
     */
    public function getTame(): string
    {
        return $this->tame;
    }

    /**
     * @return string
     */
    public function getWild(): string
    {
        return $this->wild;
    }

    public function setAngry(string $angry): void
    {
        $this->angry = $angry;
    }

    public function setTame(string $tame): void
    {
        $this->tame = $tame;
    }

    public function setWild(string $wild): void
    {
        $this->wild = $wild;
    }
}