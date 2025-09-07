<?php

namespace SnapMine\Block\Entity;

use Aternos\Nbt\Tag\CompoundTag;
use SnapMine\Block\BlockType;
use SnapMine\World\World;
use SnapMine\World\WorldPosition;

abstract class BlockEntity
{
    private bool $keepPacked = false;

    public function __construct(
        protected WorldPosition $position,
    )
    {
    }

    abstract public function getType(): BlockType;

    public function getX(): int
    {
        return (int) $this->position->getX();
    }

    public function getY(): int
    {
        return (int) $this->position->getY();
    }

    public function getZ(): int
    {
        return (int) $this->position->getZ();
    }

    public function getWorld(): World
    {
        return $this->position->getWorld();
    }

    /**
     * @return bool
     */
    public function isKeepPacked(): bool
    {
        return $this->keepPacked;
    }

    public static function load(World $world, CompoundTag $tag): BlockEntity
    {
        $x = $tag->getInt('x')->getValue();
        $y = $tag->getInt('y')->getValue();
        $z = $tag->getInt('z')->getValue();

        $self = new static(new WorldPosition($world, $x, $y, $z));

        $self->keepPacked = (bool) $tag->getByte('keepPacked')->getValue();

        return $self;
    }
}