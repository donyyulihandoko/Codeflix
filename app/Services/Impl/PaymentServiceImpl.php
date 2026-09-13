<?php

namespace App\Services\Impl;

use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Services\PaymentService;
use Override;
use App\Models\Plan;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentServiceImpl implements PaymentService
{
    public function __construct(private PaymentRepository $paymentRepository)
    {
        //
    }

    #[Override]
    public function purchase(Plan $plan): Payment
    {
        return DB::transaction(function() use($plan){
                $user = Auth::user();

                // create data payments
                $payment = $this->paymentRepository->create([
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                        'transaction_number' => $this->getReferenceNumber(),
                        'total_amount' => (int) $plan->price,
                        'status' => 'pending',
                    ]);

                // generate snaptoken
                $snapToken = $this->generateSnapToken([
                    'transaction_number' => $payment->transaction_number,
                    'total_amount' => (int) $payment->total_amount,
                    'user' => $user,
                    'plan' => $plan,
                ]);

            // update snaptoken
                $this->paymentRepository->updatePayment($payment, [
                    'midtrans_snap_token' => $snapToken,
                ]);

                $payment->midtrans_snap_token = $snapToken;

                return $payment;
        });
    }

    private function getReferenceNumber(): string
    {
        return 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }

    protected function generateSnapToken(array $data)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);

        $params = [
            'transaction_details' => [
                'order_id' => $data['transaction_number'],
                'gross_amount' => (int) $data['total_amount'],
            ],
            'customer_details' => [
                'first_name' => $data['user']->name,
                'email' => $data['user']->email,
            ],
            'item_details' => [
                [
                    'id' => (string) $data['plan']->id,
                    'price' => (int) $data['total_amount'],
                    'quantity' => 1,
                    'name' => Str::limit($data['plan']->title ?? $data['plan']->name, 50, ''),
                ],
            ],
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            Log::error('Midtrans Snap Token Error [' . $data['transaction_number'] . ']: ' . $e->getMessage());
            throw new Exception('Midtrans Error: ' . $e->getMessage());
        }

    }

    public function getPaymentByTransactionNumber(string $transactionNumber): ?Payment
    {
        return $this->paymentRepository->getPaymentByTransactionNumber($transactionNumber);
    }

    #[Override]
    public function updatePayment(Payment $payment, array $data): bool
    {
        return $this->paymentRepository->updatePayment($payment, $data);
    }
}
