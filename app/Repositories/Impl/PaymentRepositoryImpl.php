<?php

namespace App\Repositories\Impl;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Override;

class PaymentRepositoryImpl implements \App\Repositories\PaymentRepository
{
    #[Override]
    public function createPayment(array $data): Payment
    {
        return DB::transaction(function() use($data){
            return Payment::create($data);
        });
    }
}
