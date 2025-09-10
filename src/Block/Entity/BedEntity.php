<?php

namespace SnapMine\Block\Entity;

use SnapMine\Block\BlockType;
use SnapMine\World\WorldPosition;

class BedEntity extends BlockEntity
{
    public function __construct(WorldPosition $position, private readonly BlockType $type)
    {
        parent::__construct($position);
    }

    public function getType(): BlockType
    {
        return $this->type;
    }
}