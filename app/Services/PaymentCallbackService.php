<?php

namespace App\Services;

interface PaymentCallbackService
{
    public function handleCallbackPayment(array $payload);
}
