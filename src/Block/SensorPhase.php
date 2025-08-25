<?php

namespace Nirbose\PhpMcServ\Block;

enum SensorPhase: string
{
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case COOLDOWN = 'cooldown';
}
