<?php

namespace Nirbose\PhpMcServ\Block;

enum Connection: string
{
    case UP = 'up';
    case SIDE = 'side';
    case NONE = 'none';
}
