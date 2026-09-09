<?php

namespace App\Services;

interface MidtransService
{
    public function handleCallbackPayment(array $payload);
}
