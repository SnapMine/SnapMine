<?php

namespace SnapMine\Block\Entity;

use SnapMine\Block\BlockType;
use SnapMine\Block\Type\Chest;

class EnderChestEntity extends Chest
{
    public function getType(): BlockType
    {
        return BlockType::ENDER_CHEST;
    }
}