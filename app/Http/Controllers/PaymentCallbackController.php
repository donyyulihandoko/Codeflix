<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function __construct(private MidtransService $midtransService)
    {
        //
    }

    public function __invoke(Request $request)
    {
        try {
            $result = $this->midtransService->handleCallbackPayment($request->all());
            return response()->json($result['body'], $result['code']);
        } catch (\Throwable $e) {
            Log::error('Error PaymentCallbackController' . $e->getMessage());
        }
    }
}
