<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\BlockCoefficient;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Data\Waterlogged;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Material;

class Fence implements MultipleFacing, Waterlogged
{
    private array $allowedFaces = [];
    private bool $waterlogged = false;

    public function __construct(
        private readonly Material $material,
    )
    {
        $this->allowedFaces = [];
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(): int
    {
        return $this->material->getBlockId() + get_block_state_offset([
                'south' => !$this->hasFace(Direction::SOUTH),
                'west' => !$this->hasFace(Direction::WEST),
                'east' => !$this->hasFace(Direction::EAST),
                'north' => !$this->hasFace(Direction::NORTH),
                'waterlogged' => !$this->waterlogged,
            ], BlockCoefficient::getCoefficient('minecraft:' . $this->material->name));
    }

    public function getAllowedFaces(): array
    {
        return $this->allowedFaces;
    }

    public function getFaces(): array
    {
        return [
            Direction::NORTH,
            Direction::EAST,
            Direction::SOUTH,
            Direction::WEST,
        ];
    }

    public function setFace(Direction $face): void
    {
        if ($this->hasFace($face)) {
            return;
        }

        $this->allowedFaces[] = $face;
    }

    public function hasFace(Direction $face): bool
    {
        return in_array($face, $this->allowedFaces);
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