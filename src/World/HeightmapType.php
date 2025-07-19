<?php

namespace Nirbose\PhpMcServ\World;

enum HeightmapType: int
{
    case WORLD_SURFACE = 1;
    case OCEAN_FLOOR = 3;
    case MOTION_BLOCKING = 4;
    case MOTION_BLOCKING_NO_LEAVES = 5;

    public static function of(string $name): self
    {
        foreach (self::cases() as $enum) {
            if ($enum->name === $name) {
                return $enum;
            }
        }
    }
}
