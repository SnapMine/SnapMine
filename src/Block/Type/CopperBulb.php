<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Lightable;
use SnapMine\Block\Data\Powerable;

class CopperBulb extends BlockData
{
    use Powerable, Lightable;
}