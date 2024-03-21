<?php

namespace App\Models\Enums;

enum RoomCoolingSystemEnum: string
{
    case CENTRALIZED = 'Centralized';
    case INDIVIDUAL = 'Individual';
    case NONE = 'None';
}
