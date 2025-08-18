<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\Age;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Stage;
use Nirbose\PhpMcServ\Block\LeavesType;
use Nirbose\PhpMcServ\Material;

class Bamboo implements BlockData
{
    private LeavesType $leaves = LeavesType::LARGE;

    use Age, Stage;

    public function getMaximumAge(): int
    {
        return 1;
    }

    public function getMaterial(): Material
    {
        return Material::BAMBOO;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->getMaterial(), [
            'age' => $this->getAge(),
            'leaves' => $this->leaves,
            'stage' => $this->stage,
        ]);
    }

    /**
     * @param LeavesType $leaves
     */
    public function setLeaves(LeavesType $leaves): void
    {
        $this->leaves = $leaves;
    }

    /**
     * @return LeavesType
     */
    public function getLeaves(): LeavesType
    {
        return $this->leaves;
    }
}