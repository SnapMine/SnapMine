<?php

namespace SnapMine\Utils;

/**
 * Trait for handling bitwise flag operations.
 * 
 * This trait provides functionality for managing multiple boolean flags
 * stored efficiently in a single integer using bitwise operations.
 * Classes using this trait can set, unset, and check individual flags.
 * 
 * @since   0.0.1
 * 
 * @example
 * ```php
 * class MyClass {
 *     use Flags;
 *     
 *     const FLAG_VISIBLE = 1;
 *     const FLAG_ACTIVE = 2;
 *     const FLAG_ENABLED = 4;
 *     
 *     public function setVisible(bool $visible): void {
 *         $this->setFlag(self::FLAG_VISIBLE, $visible);
 *     }
 *     
 *     public function isVisible(): bool {
 *         return $this->hasFlag(self::FLAG_VISIBLE);
 *     }
 * }
 * ```
 */
trait Flags
{
    /**
     * Storage for all flags as a single integer.
     * Each bit represents a different flag state.
     * 
     * @var int
     */
    private int $flags = 0;

    /**
     * Check if a specific flag is set.
     * 
     * Uses bitwise AND operation to check if the specified flag bit
     * is set in the flags integer.
     * 
     * @param int $flag The flag to check (should be a power of 2)
     * @return bool True if the flag is set, false otherwise
     * 
     * @example
     * ```php
     * if ($this->hasFlag(MyClass::FLAG_VISIBLE)) {
     *     // Object is visible
     * }
     * ```
     */
    protected function hasFlag(int $flag): bool
    {
        return ($this->flags & $flag) === $flag;
    }

    /**
     * Set or unset a specific flag.
     * 
     * Uses bitwise operations to efficiently set or clear individual flag bits
     * without affecting other flags.
     * 
     * @param int  $flag  The flag to modify (should be a power of 2)
     * @param bool $value True to set the flag, false to unset it
     * @return void
     * 
     * @example
     * ```php
     * $this->setFlag(MyClass::FLAG_VISIBLE, true);  // Set visible flag
     * $this->setFlag(MyClass::FLAG_ACTIVE, false);  // Unset active flag
     * ```
     */
    protected function setFlag(int $flag, bool $value): void
    {
        if ($value) {
            $this->flags |= $flag;
        } else {
            $this->flags &= ~$flag;
        }
    }
}