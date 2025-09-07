<?php

namespace SnapMine\Block\Entity;

use SnapMine\Block\BlockType;
use SnapMine\Block\Entity\BlockEntity;

class DaylightDetectorEntity extends BlockEntity
{

    public function getType(): BlockType
    {
        return BlockType::DAYLIGHT_DETECTOR;
    }
}