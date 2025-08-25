<?php

namespace SnapMine\Block;

use SnapMine\World\Position;

enum Direction: string
{
    case DOWN = 'down';
    case EAST = 'east';
    case NORTH = 'north';
    case SOUTH = 'south';
    case WEST = 'west';
    case UP = 'up';

    public function getVec3(): array
    {
        return match ($this) {
            Direction::UP => [0, 1, 0],
            Direction::DOWN => [0, -1, 0],
            Direction::NORTH => [0, 0, 1],
            Direction::SOUTH => [0, 0, -1],
            Direction::EAST => [1, 0, 0],
            Direction::WEST => [-1, 0, 0],
        };
    }
}
