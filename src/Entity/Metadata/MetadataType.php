<?php

namespace SnapMine\Entity\Metadata;

/**
 * Enumeration of metadata types used in entity data serialization.
 * 
 * This enum defines all the different data types that can be stored
 * in entity metadata. Entity metadata is used to sync various properties
 * of entities between server and client, such as health, pose, variants,
 * and other entity-specific data.
 * 
 * Each metadata type corresponds to a specific way the data is serialized
 * and transmitted over the network protocol.
 * 
 * @package SnapMine\Entity\Metadata
 * @author  Nirbose
 * @since   1.0.0
 */
enum MetadataType: int
{
    /** 8-bit signed integer (-128 to 127) */
    case BYTE = 0;
    
    /** Variable-length integer (efficient for small positive numbers) */
    case VAR_INT = 1;
    
    /** Variable-length long integer (efficient for small positive longs) */
    case VAR_LONG = 2;
    
    /** 32-bit floating point number */
    case FLOAT = 3;
    
    /** UTF-8 encoded string */
    case STRING = 4;
    
    /** Text component with formatting and styling */
    case TEXT_COMPONENT = 5;
    
    /** Optional text component (can be null) */
    case OPTIONAL_TEXT_COMPONENT = 6;
    
    /** Inventory slot with item data */
    case SLOT = 7;
    
    /** Boolean value (true/false) */
    case BOOLEAN = 8;
    
    /** 3D rotation data (pitch, yaw, roll) */
    case ROTATIONS = 9;
    
    /** 3D position coordinates (x, y, z) */
    case POSITION = 10;
    
    /** Optional 3D position coordinates (can be null) */
    case OPTIONAL_POSITION = 11;
    
    /** Direction/facing value */
    case DIRECTION = 12;
    
    /** Optional reference to a living entity (can be null) */
    case OPTIONAL_LIVING_ENTITY_REFERENCE = 13;
    
    /** Block state data */
    case BLOCK_STATE = 14;
    
    /** Optional block state data (can be null) */
    case OPTIONAL_BLOCK_STATE = 15;
    
    /** Named Binary Tag (NBT) data */
    case NBT = 16;
    
    /** Single particle effect data */
    case PARTICLE = 17;
    
    /** Multiple particle effects data */
    case PARTICLES = 18;
    
    /** Villager profession and level data */
    case VILLAGER_DATA = 19;
    
    /** Optional variable-length integer (can be null) */
    case OPTIONAL_VAR_INT = 20;
    
    /** Entity pose/animation state */
    case POSE = 21;
    
    /** Cat variant/breed type */
    case CAR_VARIANT = 22;
    
    /** Cow variant/breed type */
    case COW_VARIANT = 23;
    
    /** Wolf variant/breed type */
    case WOLF_VARIANT = 24;
    
    /** Wolf sound variant type */
    case WOLF_SOUND_VARIANT = 25;
    
    /** Frog variant/breed type */
    case FROG_VARIANT = 26;
    
    /** Pig variant/breed type */
    case PIG_VARIANT = 27;
    
    /** Chicken variant/breed type */
    case CHICKEN_VARIANT = 28;
    
    /** Optional global position data (can be null) */
    case OPTIONAL_GLOBAL_POSITION = 29;
    
    /** Painting artwork variant */
    case PAINTING_VARIANT = 30;
    
    /** Sniffer entity state */
    case SNIFFER_STATE = 31;
    
    /** Armadillo entity state */
    case ARMADILLO_STATE = 32;
    
    /** 3D vector data (x, y, z) */
    case VECTOR3 = 33;
    
    /** Quaternion rotation data (x, y, z, w) */
    case QUATERNION = 34;
}
