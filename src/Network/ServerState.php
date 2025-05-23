<?php

namespace Nirbose\PhpMcServ\Network;

enum ServerState: int
{
    case HANDSHAKING = "handshaking";
    case STATUS = "status";
    case LOGIN = "login";
    case CONFIGURATION = "configuration";
    case PLAY = "play";
}