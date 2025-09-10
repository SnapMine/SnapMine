<?php

namespace SnapMine\Block\Data;

/**
 * Trait for blocks that have a distance property.
 * 
 * This trait is commonly used by blocks like leaves that need to track
 * their distance from a related block (such as logs for leaves).
 * The distance property is used in game mechanics like leaf decay,
 * where leaves too far from logs will decay over time.
 * 
 * @since   0.0.1
 * 
 * @example
 * ```php
 * class LeavesBlock {
 *     use Distance;
 *     
 *     public function shouldDecay(): bool {
 *         return $this->getDistance() > 6; // Leaves decay if more than 6 blocks from log
 *     }
 * }
 * ```
 */
trait Distance
{
    /**
     * The distance value for this block.
     * 
     * @var int The distance from a reference point (typically 1 or higher)
     */
    protected int $distance = 1;

    /**
     * Get the current distance value.
     * 
     * @return int The distance value
     * 
     * @example
     * ```php
     * $leaves = new LeavesBlock();
     * $distance = $leaves->getDistance(); // Get distance from nearest log
     * ```
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * Set the distance value.
     * 
     * @param int $distance The new distance value (typically positive integer)
     * @return void
     * 
     * @example
     * ```php
     * $leaves = new LeavesBlock();
     * $leaves->setDistance(3); // Set distance to 3 blocks from log
     * ```
     */
    public function setDistance(int $distance): void
    {
        $this->distance = $distance;
    }
}