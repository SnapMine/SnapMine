<?php

namespace Nirbose\PhpMcServ\Block;

enum Mode: string
{
    case START = 'start';
    case LOG = 'log';
    case FAIL = 'fail';
    case ACCEPT = 'accept';
    case SAVE = 'save';
    case LOAD = 'load';
    case CORNER = 'corner';
    case DATA = 'data';
}
