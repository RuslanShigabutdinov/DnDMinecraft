<?php

namespace App\Enums;

enum StatSlug: string
{
    case ArmorClass        = 'ac';
    case Initiative        = 'initiative';
    case HitPoints         = 'hp';
    case PassivePerception = 'passive-perception';
    case PassiveInsight    = 'passive-insight';
}
