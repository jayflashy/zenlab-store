<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function initPaystack($order) {
        return $order;
    }
    public function initFlutterwave($order) {}
    public function initPaypal($order) {}
    public function initCryptomus($order) {}
}
