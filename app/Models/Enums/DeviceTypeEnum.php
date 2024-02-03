<?php

namespace App\Models\Enums;

enum DeviceTypeEnum: string
{
    case SWITCH = 'Switch';
    case ROUTER = 'Router';
    case FIREWALL = 'Firewall';
    case GATEWAY = 'Security Gateway';
    case OTHER = 'Other';
    case OPTIC_PANEL = 'Fiber optic patch panel';
    case RJ45_PANEL = 'RJ45 patch panel';
    case ORGANIZER = 'Organizer';
    case SHELF = 'Rack shelf';
    case UPS = 'UPS';
    case SERVER = 'Server';
    case KVM = 'KVM console';
}
