<?php

namespace App\Models\Enums;

enum DeviceStatusEnum: string
{
    case ACTIVE = 'Device active';
    case FAILED = 'Device failed';
    case TURNED_OFF = 'Device turned off';
    case NOT_IN_USE = 'Device not in use';
    case RESERVED = 'Units reserved';
    case NOT_AVAILABLE = 'Units not available';
}
