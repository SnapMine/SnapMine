<?php

namespace Nirbose\PhpMcServ\World\Chunk;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\LongArrayTag;
use Exception;
use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Block\Block;
use Nirbose\PhpMcServ\Material;
use Nirbose\PhpMcServ\World\Location;
use Nirbose\PhpMcServ\World\Palette;

class Chunk
{
    private ?CompoundTag $nbt = null;
    private array $heightmaps = [];
    private array $sections = [];
    private array $blockEntities = [];
    private array $blockLight = [];
    private array $skyLight = [];
    private bool $loaded = false;

    public function __construct(
        private readonly int $x,
        private readonly int $z
    ) {
    }

    /**
     * @throws Exception
     */
    public function loadFromNbt(CompoundTag $nbt): self
    {
        $this->nbt = $nbt;

        $this->loadHeightmaps();
        $this->loadSections();
        $this->loadBlockEntities();

        $this->loaded = true;

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
            $bitsPerBlock = max(4, (int)ceil(log($paletteBlockCount, 2)));
            foreach ($data as $packedLong) {
                $indices = $this->unpackData($packedLong, $bitsPerBlock);

                foreach ($indices as $index) {
                    if ($index >= $paletteBlockCount) {
                        throw new Exception("Invalid block index found in chunk data! Index {$index} is out of bounds for a palette of size {$paletteBlockCount}.");
                    }
                }
            }

            $blockLight = $this->loadLightingData($section, "BlockLight");
            $skyLight = $this->loadLightingData($section, "SkyLight");
            $totalBlock = $this->getTotalBlockSection($palette, $data, $bitsPerBlock);

            $this->sections[$y] = [
                'palette' => $palette,
                'data' => $data,
                'totalBlock' => $totalBlock,
                'blockLight' => $blockLight,
                'skyLight' => $skyLight,
            ];
        }
    }

    private function getTotalBlockSection(Palette $palette, array $data, int $bitsPerBlock): int
    {
        $n = array_map(function ($packedLong) use ($palette, $bitsPerBlock) {
            $indices = $this->unpackData($packedLong, $bitsPerBlock);
            $filter = array_filter($indices, function ($index) use ($palette) {
                return $palette->getBlocks()[$index] > 0;
            });

            return array_sum($filter);
        }, $data);

        return array_sum($n);
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

    /**
     * @return bool
     */
    public function isLoaded(): bool
    {
        return $this->loaded;
    }

    public function getBlock(int $x, int $y, int $z): Block
    {
        $sectionY = $y >> 4;
        $localY = $y & 0xF;
        $localX = $x & 0xF;
        $localZ = $z & 0xF;

        $index = $localY * 16 * 16 + $localZ * 16 + $localX;
        $section = $this->sections[$sectionY];

        $palette = $section['palette'];
        $data = $section['data'];
        $paletteBlockCount = count($palette->getBlocks());
        $bitsPerBlock = max(4, (int)ceil(log($paletteBlockCount, 2)));

        $bitOffset = $index * $bitsPerBlock;
        $longIndex = $bitOffset >> 6;
        $bitOffsetInLong = $bitOffset & 0x3F;
        $packedLong = $data[$longIndex];

        $mask = (1 << $bitsPerBlock) - 1;
        $blockIndexInPalette = ($packedLong >> $bitOffsetInLong) & $mask;
        $material = Material::cases()[$palette->getBlocks()[$blockIndexInPalette]];

        return new Block(Artisan::getServer(), $material, new Location($x, $y, $z));
    }
}