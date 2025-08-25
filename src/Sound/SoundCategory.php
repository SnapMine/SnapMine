<?php

namespace SnapMine\Sound;

enum SoundCategory: int
{
    case MASTER = 0;
    case MUSIC = 1;
    case RECORDS = 2;
    case WEATHER = 3;
    case BLOCKS = 4;
    case HOSTILE = 5;
    case NEUTRAL = 6;
    case PLAYERS = 7;
    case AMBIENT = 8;
    case VOICE = 9;
}
