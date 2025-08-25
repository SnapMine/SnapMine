<?php

namespace SnapMine\Block;

enum StairsShape: string
{
    case NORTH_SOUTH = 'north_south';
    case INNER_LEFT = 'inner_left';
    case INNER_RIGHT = 'inner_right';
    case OUTER_LEFT = 'outer_left';
    case OUTER_RIGHT = 'outer_right';
    case STRAIGHT = 'straight';
}
