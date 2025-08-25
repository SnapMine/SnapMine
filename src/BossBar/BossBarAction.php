<?php

namespace SnapMine\BossBar;

enum BossBarAction: int
{
    case ADD = 0;
    case REMOVE = 1;
    case UPDATE_HEALTH = 2;
    case UPDATE_TITLE = 3;
    case UPDATE_STYLE = 4;
    case UPDATE_FLAGS = 5;
}
