<?php

namespace Nirbose\PhpMcServ\Network;

enum ServerState: string
{
    case HANDSHAKING = "handshaking";
    case STATUS = "status";
    case LOGIN = "login";
    case CONFIGURATION = "configuration";
    case PLAY = "play";
}