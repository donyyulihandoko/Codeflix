<?php

namespace App\Repositories;
use App\Models\Payment;

interface PaymentRepository
{
    public function create(array $data): Payment;

    public function updatePayment(Payment $payment, array $data): bool;

    public function getPaymentByTransactionNumber(string $transactionNumber): ?Payment;
}
