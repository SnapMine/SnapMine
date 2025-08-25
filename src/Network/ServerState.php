<?php

namespace SnapMine\Network;

enum ServerState: int
{
    case HANDSHAKE = 0;
    case STATUS = 1;
    case LOGIN = 2;
    case CONFIGURATION = 3;
    case PLAY = 4;
}