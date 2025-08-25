<?php

namespace SnapMine\Entity;

enum Pose: int
{
    case STANDING = 0;
	case FALL_FLYING = 1;
	case SLEEPING = 2;
	case SWIMMING = 3;
	case SPIN_ATTACK = 4;
	case SNEAKING = 5;
	case LONG_JUMPING = 6;
	case DYING = 7;
	case CROAKING = 8;
	case USING_TONGUE = 9;
	case SITTING = 10;
	case ROARING = 11;
	case SNIFFING = 12;
	case EMERGING = 13;
	case DIGGING = 14;
    case SLIDING = 15;
	case SHOOTING = 16;
	case INHALING = 17;
}
