<?php

namespace App\Services\Impl;

use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Services\PaymentService;
use Override;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;

class PaymentServiceImpl implements PaymentService
{
    public function __construct(private PaymentRepository $paymentRepository)
    {
        //
    }

    #[Override]
    public function purchasePlan(Plan $plan, int $amount): Payment
    {
        $user = Auth::user();
        $referenceNumber = $this->getReferenceNumber();

        $snapToken = $this->getSnapToken([
                        'user' => $user,
                        'plan_id' => $plan->id,
                        'plan' => $plan,
                        'total_amount' => $amount,
                        'reference_number' => $referenceNumber,
                    ]);

        $data = [
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'reference_number' => $referenceNumber,
            'total_amount' => $amount,
            'status' => 'pending',
            'midtrans_snap_token' => $snapToken,
            'paid_at' => null,
        ];

        return $this->paymentRepository->createPayment($data);
    }

    private function getReferenceNumber(): string
    {
        return 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }

    private function getSnapToken(array $data)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $data['reference_number'],
                'gross_amount' => (int) $data['total_amount']
            ],
            'customer_details' => [
                'first_name' => $data['user']->name,
                'email' => $data['user']->email,
            ],
            'item_details' => [
                [ 'id' => $data['plan']->id,
                'price' => (int) $data['total_amount'],
                'quantity' => 1,
                'name' => $data['plan']->name,]
            ]
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {

            Log::error('Error getting Snap token: ' . $e->getMessage());
            throw new Exception('Error getting Snap token: ' . $e->getMessage());
        }
    }
}
