<?php

namespace Nirbose\PhpMcServ\World\Chunk;

use Aternos\Nbt\Tag\CompoundTag;
use Exception;
use Nirbose\PhpMcServ\World\PalettedContainer;

class ChunkSection
{
    private int $blockCount;
    private PalettedContainer $palette;
    private array $data = [];
    private int $bitsPerBlock;

    public function __construct(CompoundTag $tag)
    {
        $this->palette = new PalettedContainer();

        $this->palette->setData($tag->getCompound('block_states')->getList('palette'));

        foreach ($tag->getLongArray('data') as $long) {
            $this->data[] = $long->getValue();
        }

        $paletteBlockCount = count($this->palette->getBlocks());
        $this->bitsPerBlock = max(4, (int)ceil(log($paletteBlockCount, 2)));
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

    /**
     * @return array
     */
    public function getBlockStates(): array
    {
        return $this->palette->getBlocks();
    }

    public function getBlock(int $localX, int $localY, int $localZ): int
    {
        $index = $localX + $localZ << 4 + $localY << 8;
        $bitOffset = $index * $this->bitsPerBlock;
        $longIndex =  $bitOffset >> 6;
        $bitOffsetInLong = $bitOffset & 0x3F;
        $mask = (1 << $this->bitsPerBlock) - 1;

        $paletteIndex = ($this->data[$longIndex] >> $bitOffsetInLong) & $mask;
        return $this->palette[$localX + $localZ << 4 + $localY << 8];
    }


    public function isEmpty(): bool
    {
        return $this->getBlockCount() === 0;
    }
}