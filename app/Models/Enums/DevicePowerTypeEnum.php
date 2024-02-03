<?php

namespace App\Models\Enums;

enum DevicePowerTypeEnum: string
{
    case EXTERNAL = 'External power supply';
    case C14 = 'IEC C14 socket';
    case PASSIVE = 'Passive equipment';
    case OTHER = 'Other';
}
