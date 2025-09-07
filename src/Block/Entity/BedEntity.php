<?php

namespace SnapMine\Block\Entity;

use SnapMine\Block\BlockType;

class BedEntity extends BlockEntity
{

    public function getType(): BlockType
    {
        return BlockType::WHITE_BED;
    }
}