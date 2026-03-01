<?php

namespace App\Enums;

enum AbilitySlug: string
{
    case Strength     = 'str';
    case Dexterity    = 'dex';
    case Constitution = 'con';
    case Intelligence = 'int';
    case Wisdom       = 'wis';
    case Charisma     = 'cha';
}
