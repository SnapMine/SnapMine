<?php

namespace Nirbose\PhpMcServ\Block;

enum HalfType: string
{
    case LOWER = 'lower';
    case UPPER = 'upper';
    case BOTTOM = 'bottom';
    case TOP = 'top';
}
