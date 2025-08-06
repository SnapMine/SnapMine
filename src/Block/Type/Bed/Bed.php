<?php

namespace Nirbose\PhpMcServ\Block\Type\Bed;

use Nirbose\PhpMcServ\Block\Data\Directional;
use Nirbose\PhpMcServ\Material;

abstract class Bed implements Directional
{
    const FOOT = 0;
    const HEAD = 1;

    private bool $occupied = false;
    private int $part = Bed::FOOT;

    protected function __construct(
        private readonly Material $material
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function getFaces(): array
    {
        return [];
    }

    public function isOccupied(): bool
    {
        return $this->occupied;
    }

    public function setOccupied(bool $occupied): void
    {
        $this->occupied = $occupied;
    }

    public function getPart(): int
    {
        return $this->part;
    }

    public function setPart(int $part): void
    {
        if ($part < 0 || $part > 1) {
            // TODO: Throw error
        }

        $this->part = $part;
    }
}