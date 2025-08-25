<?php

namespace SnapMine\Entity;

enum GameMode: int
{
    case SURVIVAL = 0;
    case CREATIVE = 1;
    case ADVENTURE = 2;
    case SPECTATOR = 3;
}
