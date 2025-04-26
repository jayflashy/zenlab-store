<?php

namespace App\Enums;

enum DiscountType: string
{
    case FIXED = 'fixed';
    case PERCENT = 'percent';
}
