<?php

namespace Nirbose\PhpMcServ\World;

class RegionLoader
{
    public static function load(string $path): Region
    {
        return new Region($path);
    }
}