<?php

namespace SnapMine\Utils;

enum DyeColor: string
{
    case WHITE = '#F9FFFE';
    case ORANGE = '#F9801D';
    case MAGENTA = '#C74EBD';
    case LIGHT_BLUE = '#3AB3DA';
    case YELLOW = '#FED83D';
    case LIME = '#80C71F';
    case PINK = '#F38BAA';
    case GRAY = '#474F52';
    case LIGHT_GRAY = '#9D9D97';
    case CYAN = '#169C9C';
    case PURPLE = '#8932B8';
    case BLUE = '#3C44AA';
    case BROWN = '#835432';
    case GREEN = '#5E7C16';
    case RED = '#B02E26';
    case BLACK = '#1D1D21';

    public function getColor(): Color
    {
        return Color::fromHex($this->value);
    }
}
