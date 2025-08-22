<?php

namespace Nirbose\PhpMcServ\Block;

enum Attachment: string
{
    case CEILING = 'ceiling';
    case DOUBLE_WALL = 'double_wall';
    case FLOOR = 'floor';
    case SINGLE_WALL = 'single_wall';
}
