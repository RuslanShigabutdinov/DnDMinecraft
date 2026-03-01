<?php

namespace App\Enums;

enum SkillSlug: string
{
    // Strength
    case Athletics     = 'athletics';

    // Dexterity
    case Acrobatics    = 'acrobatics';
    case SleightOfHand = 'sleight-of-hand';
    case Stealth       = 'stealth';

    // Intelligence
    case Arcana        = 'arcana';
    case History       = 'history';
    case Investigation = 'investigation';
    case Nature        = 'nature';
    case Religion      = 'religion';

    // Wisdom
    case AnimalHandling = 'animal-handling';
    case Insight        = 'insight';
    case Medicine       = 'medicine';
    case Perception     = 'perception';
    case Survival       = 'survival';

    // Charisma
    case Deception     = 'deception';
    case Intimidation  = 'intimidation';
    case Performance   = 'performance';
    case Persuasion    = 'persuasion';
}
