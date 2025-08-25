<?php

namespace SnapMine\Block;

enum VaultState: string
{
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case UNLOCKING = 'unlocking';
    case EJECTING = 'ejecting';
}