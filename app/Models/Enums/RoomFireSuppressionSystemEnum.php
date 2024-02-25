<?php

namespace App\Models\Enums;

enum RoomFireSuppressionSystemEnum: string
{
    case CENTRALIZED = 'Centralized';
    case INDIVIDUAL = 'Individual';
    case NONE = 'None';
    case ALARM_ONLY = 'Alarm only';
}
