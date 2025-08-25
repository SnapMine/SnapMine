<?php

namespace SnapMine\Block\Data;

use Exception;
use SnapMine\Block\Direction;

trait MultipleFacing
{
    /** @var Direction[] */
    protected array $facings = [];

    /**
     * @return Direction[]
     */
    abstract public function getAllowedFaces(): array;

    /**
     * @return Direction[]
     */
    public function getFaces(): array
    {
        return $this->facings;
    }

    /**
     * @throws Exception
     */
    public function setFace(Direction $face): void
    {
        if (in_array($face, $this->getAllowedFaces())) {
            if ($this->hasFace($face)) {
                return;
            }

            $this->facings[] = $face;
            return;
        }

        throw new Exception("Direction $face->name is not allowed.");
    }

    public function hasFace(Direction $face): bool
    {
        return in_array($face, $this->getAllowedFaces()) && in_array($face, $this->getFaces());
    }
}