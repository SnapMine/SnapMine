<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class GlassPane implements MultipleFacing, Waterlogged
{
    private bool $waterlogged = false;
    private array $faces = [];

    public function __construct(
        private readonly Material $material,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getAllowedFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getFaces(): array
    {
        return $this->faces;
    }

    public function setFace(Direction $face): void
    {
        if (in_array($face, $this->faces)) {
            return;
        }

        $this->faces[] = $face;
    }

    public function hasFace(Direction $face): bool
    {
        return in_array($face, $this->faces);
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(BlockStateLoader $loader): int
    {
        return $loader->getBlockStateId($this->material, [
            'waterlogged' => $this->waterlogged,
            'east' => $this->hasFace(Direction::EAST),
            'west' => $this->hasFace(Direction::WEST),
            'north' => $this->hasFace(Direction::NORTH),
            'south' => $this->hasFace(Direction::SOUTH),
        ]);
    }

    public function isWaterlogged(): bool
    {
        return $this->waterlogged;
    }

    public function setWaterlogged(bool $waterlogged): void
    {
        $this->waterlogged = $waterlogged;
    }
}