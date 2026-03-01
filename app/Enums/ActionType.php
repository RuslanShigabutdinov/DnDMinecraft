<?php

namespace App\Enums;

enum ActionType: int
{
    case Passive = 0;
    case Action = 1;
    case BonusAction = 2;
    case Reaction = 3;
    case OncePerCombat = 4;
}
