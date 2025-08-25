<?php

namespace SnapMine\World;

use SnapMine\World\Chunk\Chunk;

class World
{
    /** @var array<string, Region> */
    private array $regions = [];
    private string $name;

    public function __construct(string $worldFolder)
    {
        $this->name = basename($worldFolder);

        foreach (glob($worldFolder . '/region/*.mca') as $file) {
            $this->regions[basename($file, '.mca')] = new Region($file);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function hasChunk(int $x, int $z): bool
    {
        $regX = $x >> 5;
        $regZ = $z >> 5;
        $key = 'r.' . $regX . '.' . $regZ;

        if (isset($this->regions[$key])) {
            return $this->regions[$key]->hasChunk($x & 0x1F, $z & 0x1F);
        }
        return false;
    }

    public function getChunk(int $x, int $z): ?Chunk
    {
        $regX = $x >> 5;
        $regZ = $z >> 5;
        $key = 'r.' . $regX . '.' . $regZ;

        if (isset($this->regions[$key])) {
            $region = $this->regions[$key];

            return $region->getChunk($x & 0x1F, $z & 0x1F);
        }

        return null;
    }

}