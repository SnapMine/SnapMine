<?php

namespace SnapMine\Entity\Metadata;

enum MetadataType: int
{
    case BYTE = 0;
    case VAR_INT = 1;
    case VAR_LONG = 2;
    case FLOAT = 3;
    case STRING = 4;
    case TEXT_COMPONENT = 5;
    case OPTIONAL_TEXT_COMPONENT = 6;
    case SLOT = 7;
    case BOOLEAN = 8;
    case ROTATIONS = 9;
    case POSITION = 10;
    case OPTIONAL_POSITION = 11;
    case DIRECTION = 12;
    case OPTIONAL_LIVING_ENTITY_REFERENCE = 13;
    case BLOCK_STATE = 14;
    case OPTIONAL_BLOCK_STATE = 15;
    case NBT = 16;
    case PARTICLE = 17;
    case PARTICLES = 18;
    case VILLAGER_DATA = 19;
    case OPTIONAL_VAR_INT = 20;
    case POSE = 21;
    case CAR_VARIANT = 22;
    case COW_VARIANT = 23;
    case WOLF_VARIANT = 24;
    case WOLF_SOUND_VARIANT = 25;
    case FROG_VARIANT = 26;
    case PIG_VARIANT = 27;
    case CHICKEN_VARIANT = 28;
    case OPTIONAL_GLOBAL_POSITION = 29;
    case PAINTING_VARIANT = 30;
    case SNIFFER_STATE = 31;
    case ARMADILLO_STATE = 32;
    case VECTOR3 = 33;
    case QUATERNION = 34;
}
