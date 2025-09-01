<?php

namespace SnapMine\World\Chunk;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use Error;
use Exception;
use InvalidArgumentException;
use SnapMine\Block\AttachedFace;
use SnapMine\Block\Attachment;
use SnapMine\Block\AxisType;
use SnapMine\Block\Block;
use SnapMine\Block\BlockType;
use SnapMine\Block\Connection;
use SnapMine\Block\CreakingHeartState;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Direction;
use SnapMine\Block\HalfType;
use SnapMine\Block\Instrument;
use SnapMine\Block\LeavesType;
use SnapMine\Block\Mode;
use SnapMine\Block\Orientation;
use SnapMine\Block\SensorPhase;
use SnapMine\Block\StairsShape;
use SnapMine\Block\Thickness;
use SnapMine\Block\Tilt;
use SnapMine\Block\TrialSpawnerState;
use SnapMine\Block\Type\BrewingStand;
use SnapMine\Block\Type\RedstoneWire;
use SnapMine\Block\VaultState;
use SnapMine\Block\WallHeight;
use SnapMine\Material;
use SnapMine\World\PalettedContainer;

class ChunkSection
{
    private int $blockCount = 4096;
    /** @var PalettedContainer<BlockData> */
    private PalettedContainer $palettedContainer;
    private int $y;

    /**
     * @throws Exception
     */
    public function __construct(CompoundTag $tag, private array $blockLight, private array $skyLight) // TODO: Il faudrait que la logique de création soit ailleurs passer les arguments par des NBT c'es pas ouf
    {
        $this->palettedContainer = new PalettedContainer(
            $this->loadPalette($tag),
            $this->loadBlocksData($tag)
        );

        $this->y = $tag->getByte('Y')->getValue();

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

    private function getBlockDataFromNBT(CompoundTag $blockState): BlockData
    {
        $b = BlockType::find($blockState->getString("Name")->getValue())->createBlockData();
        $properties = $blockState->getCompound('Properties');

        if ($properties === null) {
            return $b;
        }

        /**
         * @var string $propName
         * @var StringTag $tag
         */
        foreach ($properties as $propName => $tag) {
            $value = $tag->getValue();

            try {
                $dir = Direction::from($propName);

                if ($b instanceof RedstoneWire) {
                    $b->setConnection($dir, Connection::from($value));
                    continue;
                } else if (!is_null(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
                    /** @phpstan-ignore method.notFound */
                    $b->setFace($dir);
                } else {
                    /** @phpstan-ignore method.notFound */
                    $b->setHeight($dir, WallHeight::from($value));
                }

                continue;
            } catch (Error) {
            }

            if (str_contains($propName, '_state')) {
                $method = 'setState';
            } else {
                $method = 'set' . str_replace('_', '', ucwords($propName, '_'));
            }

            if (method_exists($b, $method)) {
                $b->$method($this->convertPropertyValue($propName, $value));
            }
        }

        return $b;
    }

    private function convertPropertyValue(string $name, string $value): mixed
    {
        return match ($name) {
            // booleans
            'lit', 'open', 'attached', 'powered', 'waterlogged', 'hanging', 'ominous', 'drag', 'triggered', 'snowy', 'in_wall', 'persistent', 'occupied', 'has_bottle_0', 'has_bottle_1', 'has_bottle_2', 'signal_fire', 'berries', 'conditional',
            'slot_0_occupied', 'slot_1_occupied', 'slot_2_occupied', 'slot_3_occupied', 'slot_4_occupied', 'slot_5_occupied', 'crafting', 'natural', 'inverted', 'cracked', 'eye', 'enabled', 'has_record', 'has_book', 'tip',
            'bottom', 'extended', 'short', 'locked', 'bloom', 'can_summon', 'shrieking', 'unstable', 'disarmed'
            => $value === 'true',

            // int
            'age', 'level', 'rotation', 'layers', 'distance', 'dusted', 'hatch', 'stage', 'honey_level', 'candles', 'bites', 'power', 'moisture', 'segment_amount', 'note', 'flower_amount', 'delay', 'charges', 'pickles', 'eggs'
            => (int)$value,

            // enums / objets
            'facing', 'vertical_direction' => Direction::from($value),
            'face' => AttachedFace::from($value),
            'half' => HalfType::from($value),
            'shape' => StairsShape::from($value),
            'axis' => AxisType::from($value),
            'orientation' => Orientation::from($value),
            'attachment' => Attachment::from($value),
            'leaves' => LeavesType::from($value),
            'tilt' => Tilt::from($value),
            'sculk_sensor_phase' => SensorPhase::from($value),
            'mode' => Mode::from($value),
            'creaking_heart_state' => CreakingHeartState::from($value),
            'instrument' => Instrument::from($value),
            'thickness' => Thickness::from($value),
            'trial_spawner_state' => TrialSpawnerState::from($value),
            'vault_state' => VaultState::from($value),

            // fallback
            default => $value,
        };
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
                $palette[] = $this->getBlockDataFromNBT($blockStateNBT);
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
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
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
     */
    public function setBlockCount(int $blockCount): void
    {
        if ($blockCount < 0 || $blockCount > 4096) {
            throw new InvalidArgumentException('Block count must be between 0 and 4096');
        }

        $this->blockCount = $blockCount;
    }

    public function setBlock(int $localX, int $localY, int $localZ, Block $block): void
    {
        $this->palettedContainer[($localY * 256) + ($localZ * 16) + $localX] = $block->getBlockData();
    }

    public function getBlockData(int $localX, int $localY, int $localZ): BlockData
    {
        return $this->palettedContainer[($localY * 256) + ($localZ * 16) + $localX];
    }

    /**
     * @return PalettedContainer<BlockData>
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