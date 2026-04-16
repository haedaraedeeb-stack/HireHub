<?php

namespace App\Enums;

enum FreelancerStatus: string
{
    case AVAILABLE = 'available';
    case BUSY = 'busy';
    case NOT_AVAILABLE = 'not_available';
}
