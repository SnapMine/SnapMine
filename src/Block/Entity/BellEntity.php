<?php

namespace SnapMine\Block\Entity;

use SnapMine\Block\BlockType;

class BellEntity extends BlockEntity
{

    public function getType(): BlockType
    {
        return BlockType::BELL;
    }
}