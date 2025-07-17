<?php

namespace Nirbose\PhpMcServ\Component;

enum TextComponentType
{
    case TEXT;
    case TRANSLATABLE;
    case SCORE;
    case SELECTOR;
    case KEYBIND;
    case NBT;
}
