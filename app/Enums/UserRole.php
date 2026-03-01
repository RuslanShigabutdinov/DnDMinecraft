<?php

namespace App\Enums;

enum UserRole: int
{
    case Player = 0;
    case Staff = 1;
    case Admin = 2;
}
