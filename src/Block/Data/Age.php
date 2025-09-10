<?php

namespace SnapMine\Block\Data;

/**
 * Trait for blocks that have an age property.
 * 
 * This trait is used by blocks that go through different stages of growth
 * or aging, such as crops, saplings, or other time-dependent blocks.
 * The age value typically ranges from 0 to the maximum age defined by
 * the implementing class.
 * 
 * @since   0.0.1
 * 
 * @example
 * ```php
 * class WheatBlock {
 *     use Age;
 *     
 *     public function getMaximumAge(): int {
 *         return 7; // Wheat has 8 growth stages (0-7)
 *     }
 * }
 * ```
 */
trait Age
{
    /**
     * The current age of the block.
     * 
     * @var int The age value, typically ranging from 0 to getMaximumAge()
     */
    protected int $age = 0;

    /**
     * Get the maximum age this block can reach.
     * 
     * This method must be implemented by classes using this trait
     * to define the maximum age value for the specific block type.
     * 
     * @return int The maximum age value
     */
    abstract public function getMaximumAge(): int;

    /**
     * Set the age of the block.
     * 
     * @param int $age The new age value (should be between 0 and getMaximumAge())
     * @return void
     * 
     * @example
     * ```php
     * $wheat = new WheatBlock();
     * $wheat->setAge(3); // Set wheat to growth stage 3
     * ```
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * Get the current age of the block.
     * 
     * @return int The current age value
     * 
     * @example
     * ```php
     * $wheat = new WheatBlock();
     * $currentAge = $wheat->getAge(); // Returns current growth stage
     * ```
     */
    public function getAge(): int
    {
        return $this->age;
    }
}