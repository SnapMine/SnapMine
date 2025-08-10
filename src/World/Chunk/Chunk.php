<?php

namespace Nirbose\PhpMcServ\World\Chunk;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\LongArrayTag;
use Nirbose\PhpMcServ\World\Palette;

class Chunk
{
    private ?CompoundTag $nbt = null;
    private array $heightmaps = [];
    private array $sections = [];
    private array $blockEntities = [];
    private array $blockLight = [];
    private array $skyLight = [];

    public function __construct(
        private readonly int $x,
        private readonly int $z
    ) {
    }

    public function loadFromNbt(CompoundTag $nbt): self
    {
        $this->nbt = $nbt;
        $this->loadHeightmaps();
        $this->loadSections();
        $this->loadBlockEntities();
        return $this;
    }

    private function loadHeightmaps(): void
    {
        $heightmapsCompound = $this->nbt->getCompound("Heightmaps");

        if (!$heightmapsCompound) {
            return;
        }

        foreach ($heightmapsCompound as $key => $longArrayTag) {
            if ($longArrayTag instanceof LongArrayTag) {
                $heightmapData = [];
                foreach ($longArrayTag as $long) {
                    $heightmapData[] = $long;
                }
                $this->heightmaps[$key] = $heightmapData;
            }
        }
    }

    private function loadSections(): void
    {
        $sectionsTag = $this->nbt->getList("sections");
        if (!$sectionsTag) return;

        foreach ($sectionsTag as $section) {
            $y = $section->getByte("Y")->getValue();
            $palette = $this->loadPalette($section);
            $data = $this->loadBlocksData($section);

            $paletteBlockCount = count($palette->getBlocks());
            foreach ($data as $packedLong) {
                $bitsPerBlock = max(4, (int)ceil(log($paletteBlockCount, 2)));
                $indices = $this->unpackData($packedLong, $bitsPerBlock);

                foreach ($indices as $index) {
                    if ($index >= $paletteBlockCount) {
                        throw new \Exception("Invalid block index found in chunk data! Index {$index} is out of bounds for a palette of size {$paletteBlockCount}.");
                    }
                }
            }

            $blockLight = $this->loadLightingData($section, "BlockLight");
            $skyLight = $this->loadLightingData($section, "SkyLight");

            $this->sections[$y] = [
                'palette' => $palette,
                'data' => $data,
                'blockLight' => $blockLight,
                'skyLight' => $skyLight,
            ];
        }
    }

    private function unpackData(int|string $packedLong, int $bitsPerBlock): array
    {
        $indices = [];
        $long = (int)$packedLong;
        $indicesPerLong = floor(64 / $bitsPerBlock);
        $mask = (1 << $bitsPerBlock) - 1;

        for ($i = 0; $i < $indicesPerLong; $i++) {
            $shift = $i * $bitsPerBlock;
            $index = ($long >> $shift) & $mask;
            $indices[] = $index;
        }

        return $indices;
    }

    private function loadPalette(CompoundTag $section): Palette
    {
        $blockStates = $section->getCompound("block_states");
        if (!$blockStates) {
            return new Palette();
        }

        $paletteList = $blockStates->getList("palette");
        if (!$paletteList) {
            return new Palette();
        }

        $palette = new Palette();
        $palette->addBlocks($paletteList);

        return $palette;
    }

    private function loadBlocksData(CompoundTag $section): array
    {
        $blockStates = $section->getCompound("block_states");
        if (!$blockStates) {
            return [];
        }

        $data = $blockStates->getLongArray("data");
        if (!$data) {
            return [];
        }

        $blockData = [];
        foreach ($data as $long) {
            $blockData[] = $long;
        }

        return $blockData;
    }

    private function loadLightingData(CompoundTag $section, string $key): array
    {
        $lightingTag = $section->getByteArray($key);
        if (!$lightingTag) return [];

        $lightingData = [];
        foreach ($lightingTag as $lighting) {
            $lightingData[] = $lighting;
        }

        return $lightingData;
    }

    private function loadBlockEntities(): void
    {
        $blockEntitiesTag = $this->nbt->getList("block_entities");
        if (!$blockEntitiesTag) return;

        foreach ($blockEntitiesTag as $blockEntity) {
            if ($blockEntity instanceof CompoundTag) {
                $this->blockEntities[] = [
                    'type' => $blockEntity->getString('id')->getValue(),
                    'x' => $blockEntity->getInt('x')->getValue(),
                    'y' => $blockEntity->getInt('y')->getValue(),
                    'z' => $blockEntity->getInt('z')->getValue(),
                    // ... other block entity data
                ];
            }
        }
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
     * @return array
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @return array
     */
    public function getBlockLight(): array
    {
        return $this->blockLight;
    }

    /**
     * @return array
     */
    public function getSkyLight(): array
    {
        return $this->skyLight;
    }

    /**
     * @return array
     */
    public function getBlockEntities(): array
    {
        return $this->blockEntities;
    }

    /**
     * @return array
     */
    public function getHeightmaps(): array
    {
        return $this->heightmaps;
    }

    public function dump(): array
    {
        return [
            $this->x,
            $this->z,
            $this->sections,
            $this->blockLight,
            $this->skyLight,
            $this->blockEntities,
            $this->heightmaps,
        ];
    }
}