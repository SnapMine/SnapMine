<?php

namespace SnapMine\Block\Entity;

use SnapMine\Block\BlockType;

class EndPortalEntity extends BlockEntity
{

    public function getType(): BlockType
    {
        return BlockType::END_PORTAL;
    }
}