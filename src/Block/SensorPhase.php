<?php

namespace SnapMine\Block;

enum SensorPhase: string
{
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case COOLDOWN = 'cooldown';
}
