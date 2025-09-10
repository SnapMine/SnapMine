<?php

namespace SnapMine;

/**
 * Interface for objects that have a unique string key identifier.
 * 
 * This interface is used throughout the SnapMine system to identify
 * various objects such as materials, entities, blocks, and other keyed resources.
 * 
 * @package SnapMine
 * @author  Nirbose
 * @since   1.0.0
 */
interface Keyed
{
    /**
     * Get the unique string key that identifies this object.
     * 
     * The key should be unique within the context where this object is used
     * and should follow Minecraft naming conventions (e.g., "minecraft:stone").
     * 
     * @return string The unique identifier key for this object
     * 
     * @example
     * ```php
     * $material = Material::STONE;
     * echo $material->getKey(); // "minecraft:stone"
     * ```
     */
    public function getKey(): string;
}