<?php

namespace Nirbose\PhpMcServ\Block;

enum Direction: string
{
    case DOWN = 'down';
    case EAST = 'east';
    case NORTH = 'north';
    case SOUTH = 'south';
    case WEST = 'west';
    case UP = 'up';
}
