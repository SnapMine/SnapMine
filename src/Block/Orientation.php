<?php

namespace Nirbose\PhpMcServ\Block;

enum Orientation: string
{
    case DOWN_EAST = 'down_east';
    case DOWN_NORTH = 'down_north';
    case DOWN_SOUTH = 'down_south';
    case DOWN_WEST = 'down_west';
    case EAST_UP = 'east_up';
    case NORTH_UP = 'north_up';
    case SOUTH_UP = 'south_up';
    case UP_EAST = 'up_east';
    case UP_NORTH = 'up_north';
    case UP_SOUTH = 'up_south';
    case WEST_UP = 'west_up';
}
