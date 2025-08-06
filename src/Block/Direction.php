<?php

namespace Nirbose\PhpMcServ\Block;

enum Direction: int
{
    case DOWN = 0;
    case EAST = 1;
    case NORTH = 2;
    case SOUTH = 3;
    case WEST = 4;
    case UP = 5;
}
