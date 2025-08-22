<?php

namespace Nirbose\PhpMcServ\Block;

enum Thickness: string
{
    case TIP_MERGE = 'tip_merge';
    case TIP = 'tip';
    case FRUSTUM = 'frustum';
    case MIDDLE = 'middle';
    case BASE = 'base';
}
