<?php

namespace App\Repositories;
use App\Models\Payment;

interface PaymentRepository
{
    public function createPayment(array $data): Payment;

    // public function updatePaymentStatus(string $referenceNumber, string $status): bool;

    // public function getPaymentByReferenceNumber(string $referenceNumber): Payment;
}
