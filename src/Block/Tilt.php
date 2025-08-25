<?php

namespace SnapMine\Block;

enum Tilt: string
{
    case FULL = 'full';
    case NONE = 'none';
    case PARTIAL = 'partial';
    case UNSTABLE = 'unstable';
}
