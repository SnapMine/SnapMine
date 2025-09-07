<?php

namespace SnapMine\Block\Entity;

use SnapMine\Block\BlockType;

class EnderChestEntity extends BlockEntity
{
    public function getType(): BlockType
    {
        return BlockType::ENDER_CHEST;
    }
}