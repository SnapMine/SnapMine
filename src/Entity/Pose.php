<?php

namespace SnapMine\Entity;

/**
 * Enumeration of entity poses and animation states.
 * 
 * Entity poses represent different visual states and animations that entities
 * can be in, affecting how they are rendered and their collision properties.
 * Each pose corresponds to a specific animation or position the entity can take.
 * 
 * @package SnapMine\Entity
 * @author  Nirbose
 * @since   1.0.0
 */
enum Pose: int
{
    /** Default standing/idle pose */
    case STANDING = 0;
    
    /** Flying pose when using elytra */
    case FALL_FLYING = 1;
    
    /** Sleeping pose (in beds) */
    case SLEEPING = 2;
    
    /** Swimming pose when in water */
    case SWIMMING = 3;
    
    /** Spin attack pose (trident riptide) */
    case SPIN_ATTACK = 4;
    
    /** Sneaking/crouching pose */
    case SNEAKING = 5;
    
    /** Long jumping pose (goats) */
    case LONG_JUMPING = 6;
    
    /** Dying animation pose */
    case DYING = 7;
    
    /** Croaking pose (frogs) */
    case CROAKING = 8;
    
    /** Using tongue pose (frogs) */
    case USING_TONGUE = 9;
    
    /** Sitting pose (tamed animals) */
    case SITTING = 10;
    
    /** Roaring pose (wardens) */
    case ROARING = 11;
    
    /** Sniffing pose (sniffers) */
    case SNIFFING = 12;
    
    /** Emerging pose (wardens) */
    case EMERGING = 13;
    
    /** Digging pose (wardens, sniffers) */
    case DIGGING = 14;
    
    /** Sliding pose (players on ice/slime) */
    case SLIDING = 15;
    
    /** Shooting pose (crossbow, bow) */
    case SHOOTING = 16;
    
    /** Inhaling pose (wardens) */
    case INHALING = 17;
}
