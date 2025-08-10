<?php

namespace Nirbose\PhpMcServ\World;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\ListTag;
use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Block\BlockType;

class Palette
{
    private array $blocks = [];

    // Temp
    private array $blocksIdMap = [
        'minecraft:bedrock' => 85,
        'minecraft:air' => 0,
        'minecraft:dirt' => 10,
        'minecraft:grass_block' => 9,
    ];
    private int $count = 50;
    private int $blockCount = 0;

    public function __construct()
    {
    }

    public function addBlocks(ListTag $blocks): void
    {
        /** @var CompoundTag $block */
        foreach ($blocks as $block) {
            $tag = $block->getString("Name");

            if (is_null($tag)) {
                continue;
            }

            $identifier = $tag->getValue();

            $b = BlockType::find($identifier)->createBlockData();
            $properties = $block->getCompound('Properties');
            $props = [];

            if ($properties == null) {
                $value = $b->getMaterial()->getBlockId();
            } else {
                foreach ($properties as $k => $p) {
                    $props[$k] = $p->getValue();
                }

                $value = Artisan::getBlockStateLoader()->getBlockStateId($b->getMaterial(), $props);
            }

            if ($value > 0) {
                $this->blockCount++;
            }

            if (in_array($value, $this->blocks)) {
                continue;
            }

            $this->blocks[] = $value;
        }
    }

    /**
     * @return array
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function getBlockCount(): int
    {
        return $this->blockCount;
    }
}