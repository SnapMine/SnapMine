<?php

namespace Nirbose\PhpMcServ\World\Chunk;

use Aternos\Nbt\Tag\CompoundTag;
use Exception;
use Nirbose\PhpMcServ\Block\AttachedFace;
use Nirbose\PhpMcServ\Block\BlockType;
use Nirbose\PhpMcServ\Block\Data\Age;
use Nirbose\PhpMcServ\Block\Data\Attached;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\FaceAttachable;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Level;
use Nirbose\PhpMcServ\Block\Data\Lightable;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Data\Openable;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Data\Rotatable;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;
use Nirbose\PhpMcServ\World\PalettedContainer;

class ChunkSection
{
    private int $blockCount = 4096;
    private PalettedContainer $palettedContainer;

    /**
     * @throws Exception
     */
    public function __construct(CompoundTag $tag, private array $blockLight, private array $skyLight) // TODO: Il faudrait que la logique de création soit ailleurs passer les arguments par des NBT c'es pas ouf
    {
        $this->palettedContainer = new PalettedContainer(
            $this->loadPalette($tag),
            $this->loadBlocksData($tag)
        );

        $index = array_search(BlockType::AIR->createBlockData(), $this->palettedContainer->getPalette());

        if (is_int($index)) {
            $this->blockCount = 0;
            for ($i = 0; $i < 4096; $i++) {
                if (Material::AIR !== $this->palettedContainer[$i]->getMaterial()) {
                    $this->blockCount++;
                }
            }
        }
    }

    private function getBlockFromNBT(CompoundTag $blockState): BlockData
    {
        $b = BlockType::find($blockState->getString("Name")->getValue())->createBlockData();
        $properties = $blockState->getCompound('Properties');

        if ($properties == null) {
            return $b;
        }

        if (has_trait(Age::class, $b)) {
            /** @var Age $b */
            $b->setAge(intval($properties->getString("age")->getValue()));
        }

        if (has_trait(Attached::class, $b)) {
            /** @var Attached $b */
            $b->setAttached($properties->getString("attached")->getValue() === "true");
        }

        if (has_trait(FaceAttachable::class, $b)) {
            /** @var FaceAttachable $b */
            $b->setAttachedFace(AttachedFace::from($properties->getString("face")->getValue()));
        }

        if (has_trait(Facing::class, $b)) {
            /** @var Facing $b */
            $b->setFacing(Direction::from($properties->getString("facing")->getValue()));
        }

        if (has_trait(Level::class, $b)) {
            /** @var Level $b */
            $b->setLevel(intval($properties->getString("level")->getValue()));
        }

        if (has_trait(Lightable::class, $b)) {
            /** @var Lightable $b */
            $b->setLit($properties->getString("lit")->getValue() === "true");
        }

        if (has_trait(MultipleFacing::class, $b)) {
            /** @var MultipleFacing $b */
            foreach ($b->getAllowedFaces() as $face) {
                if ($properties->getString(strtolower($face->name))->getValue() === "true") {
                    $b->setFace($face);
                }
            }
        }
        if (has_trait(Openable::class, $b)) {
            /** @var Openable $b */
            $b->setOpen($properties->getString("open")->getValue() === "true");
        }

        if (has_trait(Powerable::class, $b)) {
            /** @var Powerable $b */
            $b->setPower($properties->getString("powered")->getValue() === "true");
        }

        if (has_trait(Rotatable::class, $b)) {
            /** @var Rotatable $b */
            $b->setRotation(intval($properties->getString("rotation")->getValue()));
        }

        if (has_trait(Waterlogged::class, $b)) {
            /** @var Waterlogged $b */
            $b->setWaterlogged($properties->getString("waterlogged")->getValue() === "true");
        }

        return $b;
    }

    /**
     * @throws Exception
     */
    private function loadPalette(CompoundTag $section): array
    {
        $palette = [];
        $blockStatesCompound = $section->getCompound("block_states");
        if (!$blockStatesCompound) {
            return [BlockType::AIR->createBlockData()];
        }

        $paletteList = $blockStatesCompound->getList("palette");
        if (!$paletteList) {
            return [BlockType::AIR->createBlockData()];
        }

        foreach ($paletteList as $blockStateNBT) {
            if (!$blockStateNBT instanceof CompoundTag) {
                throw new Exception("Invalid block state in palette, expected CompoundTag.");
            }
            try {
                $palette[] = $this->getBlockFromNBT($blockStateNBT);
            } catch (\Throwable $e) {
                file_put_contents("err.txt", $blockStateNBT->__toString());
                throw new Exception("Failed to load block from NBT: " . $e->getMessage());
            }

        }

        return $palette;
    }


    private function loadBlocksData(CompoundTag $section): array
    {
        $blockStates = $section->getCompound("block_states");
        if (!$blockStates) {
            return [0];
        }

        $data = $blockStates->getLongArray("data");
        if (!$data) {
            return [0];
        }

        $blockData = [];
        foreach ($data as $long) {
            $blockData[] = $long;
        }

        return $blockData;
    }


    /**
     * Get total block in this chunk
     * @return int
     */
    public function getBlockCount(): int
    {
        return $this->blockCount;
    }

    /**
     * @param int $blockCount
     * @throws Exception
     */
    public function setBlockCount(int $blockCount): void
    {
        if ($blockCount < 0 || $blockCount > 4096) {
            throw new Exception('Block count must be between 0 and 4096');
        }

        $this->blockCount = $blockCount;
    }

    public function getBlockData(int $localX, int $localY, int $localZ): BlockData
    {
        return $this->palettedContainer[$localX + $localZ << 4 + $localY << 8];
    }

    /**
     * @return PalettedContainer
     */
    public function getPalettedContainer(): PalettedContainer
    {
        return $this->palettedContainer;
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

    public function isEmpty(): bool
    {
        return $this->getBlockCount() === 0;
    }
}