<?php

namespace Nirbose\PhpMcServ\World;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\IntArrayTag;
use Aternos\Nbt\Tag\IntValueTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Block\BlockType;

class Palette
{
    /** @var array<int> $blocks */
    private array $blocks = [];
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

            if (is_null($b)) {
                return;
            }

            $properties = $block->getCompound('Properties');
            $props = [];

            if ($properties == null) {
                $value = $b->getMaterial()->getBlockId();
            } else {
                foreach ($properties as $k => $p) {
                    if ($p instanceof IntValueTag || $p instanceof StringTag)
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
     * @return array<int>
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