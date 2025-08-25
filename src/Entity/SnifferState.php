<?php

namespace SnapMine\Entity;

enum SnifferState: int
{
    case IDLING = 0;
    case FEELING_HAPPY = 1;
    case SCENTING = 2;
    case SNIFFING = 3;
    case SEARCHING = 4;
    case DIGGING = 5;
    case RISING = 6;
}
