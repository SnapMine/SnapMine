<?php

namespace Nirbose\PhpMcServ\Block;

enum Tilt: string
{
    case FULL = 'full';
    case NONE = 'none';
    case PARTIAL = 'partial';
    case UNSTABLE = 'unstable';
}
