<?php

namespace Nirbose\PhpMcServ\World;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\LongArrayTag;

class Chunk
{
    private array $heightmaps;
    private Palette $palette;
    private array $data = [];

    public function __construct(
        private readonly int $x,
        private readonly int $z,
        private readonly CompoundTag $nbt
    ) {
        $this->palette = new Palette();

        $this->loadHeightmaps();
        $this->loadBlocksData();
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getZ(): int
    {
        return $this->z;
    }

    /**
     * @return CompoundTag
     */
    public function getNbt(): CompoundTag
    {
        return $this->nbt;
    }

    private function loadHeightmaps(): void
    {
        $heightmapsCompound = $this->nbt->getCompound("Heightmaps");

        if (!$heightmapsCompound) return;

        foreach ($heightmapsCompound as $key => $longArrayTag) {
            if ($longArrayTag instanceof LongArrayTag) {
                $heightmapData = [];
                foreach ($longArrayTag as $long) {
                    $heightmapData[] = $long; // int|string
                }
                $this->heightmaps[$key] = $heightmapData;
            }
        }
    }

    /**
     * @return array
     */
    public function getHeightmaps(): array
    {
        return $this->heightmaps;
    }

    private function loadBlocksData(): void
    {
        $sections = $this->nbt->getList("sections");

        /** @var CompoundTag $section */
        foreach ($sections as $section) {
            $blockStates = $section->getCompound("block_states");

            if ($blockStates) {
                $longs = $blockStates->getLongArray("data") ?? [];

                foreach ($longs as $long) {
                    $this->data[] = $long;
                }

                $this->palette->addBlocks($blockStates->getList("palette"));
            }
        }
    }

    /**
     * @return Palette
     */
    public function getPalette(): Palette
    {
        return $this->palette;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}