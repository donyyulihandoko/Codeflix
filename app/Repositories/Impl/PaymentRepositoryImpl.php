<?php

namespace App\Repositories\Impl;

use App\Models\Payment;
use Override;

class PaymentRepositoryImpl implements \App\Repositories\PaymentRepository
{
    #[Override]
    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    #[Override]
    public function updatePayment(Payment $payment, array $data): bool
    {
        return $payment->update($data);
    }

    public function getPaymentByTransactionNumber(string $transactionNumber): ?Payment
    {
        return Payment::query()
            ->with(['user', 'plan'])
            ->where('transaction_number', $transactionNumber)
            ->first();
    }


}
