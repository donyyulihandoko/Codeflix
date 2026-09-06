<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Plan;

interface PaymentService
{
    public function purchasePlan(Plan $plan, int $amount): Payment;
}
