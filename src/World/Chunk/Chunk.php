<?php

namespace SnapMine\World\Chunk;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\LongArrayTag;
use Exception;
use SnapMine\Artisan;
use SnapMine\Block\Block;
use SnapMine\Block\BlockType;
use SnapMine\World\Position;
use SnapMine\World\World;
use SnapMine\World\WorldPosition;

class Chunk
{
    private array $heightmaps = [];
    /** @var ChunkSection[] */
    private array $sections = [];
    private array $blockEntities = [];
    private array $blockLight = [];
    private array $skyLight = [];
    private bool $loaded = false;

    public function __construct(
        private readonly World $world,
        private readonly int   $x,
        private readonly int   $z
    )
    {
    }

    /**
     * @throws Exception
     */
    public function loadFromNbt(CompoundTag $nbt): self
    {

        $this->loadHeightmaps($nbt);
        $this->loadSections($nbt);
        $this->loadBlockEntities($nbt);

        $this->loaded = true;

        return $this;
    }

    private function loadHeightmaps(CompoundTag $nbt): void
    {
        $heightmapsCompound = $nbt->getCompound("Heightmaps");

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

    /**
     * @throws Exception
     */
    private function loadSections(CompoundTag $tag): void
    {
        $sectionsTag = $tag->getList("sections");
        if (!$sectionsTag) return;

        foreach ($sectionsTag as $section) {
            $y = $section->getByte("Y")->getValue();

            $blockLight = $this->loadLightingData($section, "BlockLight");
            $skyLight = $this->loadLightingData($section, "SkyLight");

            //try {
            $this->sections[$y] = new ChunkSection($section, $blockLight, $skyLight);
            //} catch (Exception $exception) {
            //   throw new Exception("Failed to load chunk section at Y={$y}: " . $exception->getMessage());
            //}
        }
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

    private function loadBlockEntities(CompoundTag $tag): void
    {
        $blockEntitiesTag = $tag->getList("block_entities");
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

    public function __debugInfo(): array
    {
        return [
            $this->x,
            $this->z,
            $this->blockEntities,
            $this->loaded,
        ];
    }

    /**
     * @return bool
     */
    public function isLoaded(): bool
    {
        return $this->loaded;
    }

    public function getBlock(Position $pos): Block
    {
        $x = floor($pos->getX());
        $y = floor($pos->getY());
        $z = floor($pos->getZ());

        $sectionIndex = $y >> 4;
        $worldPosition = WorldPosition::fromPosition($this->world, $pos);

        if (!isset($this->sections[$sectionIndex])) {
            return new Block(Artisan::getServer(), $worldPosition, BlockType::AIR->createBlockData());
        }

        $blockData = $this->sections[$sectionIndex]
            ->getBlockData($x & 0xF, $y & 0xF, $z & 0xF);

        return new Block(Artisan::getServer(), $worldPosition, $blockData);
    }

    public function setBlock(Position $pos, Block $block): void
    {
        $sectionIndex = $pos->getY() >> 4;

        $this->sections[$sectionIndex]
            ->setBlock($pos->getX() & 0xF, $pos->getY() & 0xF, $pos->getZ() & 0xF, $block);
    }

    public function getSection(float $getY): ?ChunkSection
    {
        $sectionIndex = (int)$getY >> 4;

        return $this->sections[$sectionIndex] ?? null;
    }
}