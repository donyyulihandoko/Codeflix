<?php

namespace App\Services\Impl;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use App\Repositories\PaymentRepository;
use App\Repositories\SubscriptionRepository;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransServiceImpl implements MidtransService
{

    public function __construct(private SubscriptionRepository $subscriptionRepository, private PaymentRepository $paymentRepository)
    {
        //
    }

    public function handleCallbackPayment(array $payload)
    {
        try {
                //  1. Signature key validation
                if(!$this->isValidSignatureKey($payload)) {
                    return [
                        'code' => 400,
                        'body' => ['status' => 'error', 'message' => 'Invalid signature key']
                    ];
                };

                // 2. Get data payment
                $orderId = $payload['order_id'] ?? '';
                $payment = $this->paymentRepository->getPaymentByTransactionNumber($orderId);

                // 3. If payment data not found
                if(!$payment){
                    return [
                            'code' => 404,
                            'body' => ['status' => 'error', 'message' => 'Payment not found']
                    ];
                }

                // 4. Idempotency guard
                if($payment->status === 'success'){
                    return [
                            'code' => 200,
                            'body' => ['status' => 'success', 'message' => 'Payment already processed']
                        ];
                }

                $transactionStatus = $payload['transaction_status'] ?? '';

                // 5. payment success validation
                if($this->isPaymentSuccess($payload)){
                    $user = $payment->user;
                    $plan = $payment->plan;

                    if(!$user || !$plan){
                        return [
                            'code' => 422,
                            'body' => ['status' => 'error', 'message' => 'User or Plan relation missing']
                        ];
                    }

                    // 6. Generate Data subscription dan update data payment
                    $this->processSuccessfulSubscription($payment, $user, $plan, $payload['payment_type'] ?? 'midtrans');
                }


                // 7. kalau transaksi gagal
                if (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                    $this->paymentRepository->updatePayment($payment, [
                        'status' => 'failed'
                    ]);
                }

                //8. Return
                return [
                    'code' => 200,
                    'body' => ['status' => 'success']
                ];



        } catch (\Throwable $e) {

            Log::error('Midtrans Service Exception: ' . $e->getMessage(), [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'code' => 500,
                'body' => ['status' => 'error', 'message' => 'Internal server error']
            ];
        }
    }

    private function isValidSignatureKey(array $payload): bool
    {
        $serverKey = config('midtrans.server_key');
        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signatureKey = $payload['signature_key'] ?? '';

        $hashed = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return strtolower($hashed) === strtolower($signatureKey);
    }

    private function isPaymentSuccess(array $payload)
    {
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status'] ?? '';

        // 1. credit card dll
        if($transactionStatus == 'capture') return $fraudStatus === 'accept';

        // qrish mbanking
        return $transactionStatus === 'settlement';
    }

    private function processSuccessfulSubscription(Payment $payment, User $user, Plan $plan, String $paymentType)
    {
        return  DB::transaction(function() use($payment, $user, $plan, $paymentType){
            $startDate = now();
            $endDate   = now()->addDays((int) $plan->duration);

            $this->subscriptionRepository->create([
                'plan_id' => $plan->id,
                'user_id'=> $user->id,
                'active' => true,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            $this->paymentRepository->updatePayment($payment, [
                'status' => 'success',
                'payment_type' => $paymentType
            ]);
        });
    }
}
