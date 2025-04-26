<?php

namespace App\Enums;

enum CouponType: string
{
    case GENERAL = 'general';
    case PRODUCT = 'product';
    case CATEGORY = 'category';
}
