<?php

namespace Nirbose\PhpMcServ\Entity\Animal;

enum ArmadilloState: int
{
    case IDLE = 0;
    case ROLLING = 1;
    case SCARED = 2;
    case UNROLLING = 3;
}
