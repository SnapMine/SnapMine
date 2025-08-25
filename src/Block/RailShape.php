<?php

namespace SnapMine\Block;

enum RailShape: string
{
    case ASCENDING_EAST = 'ascending_east';
    case ASCENDING_SOUTH = 'ascending_south';
    case ASCENDING_WEST = 'ascending_west';
    case ASCENDING_NORTH = 'ascending_north';
    case EAST_WEST = 'east_west';
    case NORTH_EAST = 'north_east';
    case NORTH_SOUTH = 'north_south';
    case NORTH_WEST = 'north_west';
    case SOUTH_EAST = 'south_east';
    case SOUTH_WEST = 'south_west';
}
