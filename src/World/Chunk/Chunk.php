<?php

namespace Nirbose\PhpMcServ\World\Chunk;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\LongArrayTag;
use Nirbose\PhpMcServ\World\Palette;

class Chunk
{
    private array $heightmaps;
    private Palette $palette;
    private array $data = [];
    private array $sections = [];

    public function __construct(
        private readonly int $x,
        private readonly int $z,
        private readonly CompoundTag $nbt
    ) {
        $this->palette = new Palette();

        $this->loadHeightmaps();
        $this->loadBlocksData();

        file_put_contents("oui.txt", print_r($this->sections, true));
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

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->sections;
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
            $y = $section->getByte("Y")->getValue();

            $blockStates = $section->getCompound("block_states");
            if (!$blockStates) continue;

            $data = $blockStates->getLongArray("data") ?? [];
            $paletteList = $blockStates->getList("palette");

            $palette = new Palette();
            $palette->addBlocks($paletteList);

            $this->sections[$y] = [
                'palette' => $palette
            ];

            foreach ($data as $long) {
                $this->sections[$y]['data'][] = $long;
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