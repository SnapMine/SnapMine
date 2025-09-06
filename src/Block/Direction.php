<?php

namespace SnapMine\Block;

enum Direction: string
{
    case DOWN = 'down';
    case UP = 'up';
    case NORTH = 'north';
    case SOUTH = 'south';
    case WEST = 'west';
    case EAST = 'east';

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
