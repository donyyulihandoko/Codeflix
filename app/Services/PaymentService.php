<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Plan;

interface PaymentService
{
    public function purchase(Plan $plan): Payment;

    public function getPaymentByTransactionNumber(string $transactionNumber): ?Payment;

    public function updatePayment(Payment $payment, array $data): bool;
}
