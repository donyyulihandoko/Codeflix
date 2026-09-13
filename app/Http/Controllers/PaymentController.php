<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
        //
    }

    public function purchase(Plan $plan)
    {
        try {
                $payment = $this->paymentService->purchase($plan);
                return response()->json([
                    'status' => 'success',
                    'midtrans_snap_token' => $payment->midtrans_snap_token,
                ]);

        } catch (\Throwable $e) {
            Log::error('Payment Purchase Error: ' . $e->getMessage());
            return response()->json([
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ], 500);
        }
    }


    // public function callback(Request $request)
    // {
    //     try {
    //         $serverKey = config('midtrans.server_key');
    //         $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    //         if (strtolower($hashed) === strtolower($request->signature_key)) {

    //             $payment = $this->paymentService->getPaymentByTransactionNumber($request->order_id);

    //             if ($payment) {

    //                 // 1. IDEMPOTENCY GUARD: Jika transaksi sudah sukses, langsung return HTTP 200 OK
    //                 // Mencegah pembuatan subscription ganda saat retry notifikasi
    //                 if ($payment->status === 'success') {
    //                     return response()->json([
    //                         'status' => 'success',
    //                         'message' => 'Payment already processed'
    //                     ]);
    //                 }

    //                 $transactionStatus = $request->transaction_status;
    //                 $fraudStatus = $request->fraud_status;

    //                 // 2. CEK KELAYAKAN PEMBAYARAN SUKSES
    //                 $isSuccess = false;

    //                 if ($transactionStatus == 'capture') {
    //                     // Kartu Kredit wajib fraud_status = accept
    //                     if ($fraudStatus == 'accept') {
    //                         $isSuccess = true;
    //                     }
    //                 } elseif ($transactionStatus == 'settlement') {
    //                     // QRIS, GoPay, Transfer Bank, dll.
    //                     $isSuccess = true;
    //                 }

    //                 if ($isSuccess) {
    //                     $user = $payment->user;
    //                     $plan = $payment->plan;

    //                     try {
    //                         DB::transaction(function () use ($payment, $plan, $user, $request) {

    //                             $this->subscriptionService->createSubscription($user, $plan);

    //                             $this->paymentService->updatePayment($payment, [
    //                                 'status'       => 'success',
    //                                 'payment_type' => $request->payment_type,
    //                             ]);

    //                         });
    //                     } catch (\Throwable $e) {
    //                         Log::error('Failed to process successful payment: ' . $e->getMessage());
    //                         return response()->json([
    //                             'status'  => 'error',
    //                             'message' => 'Failed to process membership'
    //                         ], 500);
    //                     }
    //                 } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
    //                     $this->paymentService->updatePayment($payment, [
    //                             ['status' => 'failed']
    //                     ]);
    //                 }

    //                 return response()->json(['status' => 'success']);
    //             }

    //             return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
    //         }

    //         return response()->json(['status' => 'error', 'message' => 'Invalid signature key'], 400);

    //     } catch (\Throwable $e) {
    //         Log::error('Midtrans Callback Exception: ' . $e->getMessage(), [
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         // Log::error('Payment Callback Error: ' . $e->getMessage());
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    //     }
    // }

}
