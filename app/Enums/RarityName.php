<?php

namespace App\Enums;

enum RarityName: string
{
    case Common    = 'common';
    case Uncommon  = 'uncommon';
    case Rare      = 'rare';
    case Legendary = 'legendary';
}
