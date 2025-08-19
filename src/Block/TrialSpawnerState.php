<?php

namespace Nirbose\PhpMcServ\Block;

enum TrialSpawnerState: string
{
    case INACTIVE = 'inactive';
    case WAITING_FOR_PLAYERS = 'waiting_for_players';
    case ACTIVE = 'active';
    case WAITING_FOR_REWARD_EJECTION = 'waiting_for_reward_ejection';
    case EJECTING_REWARD = 'ejecting_reward';
    case COOLDOWN = 'cooldown';
}
