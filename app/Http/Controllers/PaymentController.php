<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Models\Plan;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);

        Config::$curlOptions = [
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ];
    }

    // public function purchase(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'plan_id' => ['required', 'exists:plans,id'],
    //         'amount'  => ['required', 'numeric'],
    //     ]);

    //     try {
    //         $plan = Plan::findOrFail($request->plan_id);
    //         $referenceNumber = 'PAY-' . date('Ymd') . '-' . time() . '-' . $user->id;

    //         // 1. Simpan Transaksi Ke Database (Gunakan nama kolom yang sesuai di Model Payment)
    //         $transaction = Payment::query()->create([
    //             'user_id'             => $user->id,
    //             'plan_id'             => $plan->id,
    //             'transaction_number'    => $referenceNumber,
    //             'total_amount'        => $request->amount, // Menggunakan $request->amount dari Fetch JS
    //             'status'              => 'pending',
    //             'midtrans_snap_token' => null,
    //         ]);

    //         // 2. Buat Payload Midtrans Snap
    //         $params = [
    //             'transaction_details' => [
    //                 'order_id'     => $transaction->transaction_number,
    //                 'gross_amount' => (int) $transaction->total_amount,
    //             ],
    //             'customer_details' => [
    //                 'first_name' => $user->name,
    //                 'email'      => $user->email,
    //             ],
    //             'item_details' => [
    //                 [
    //                     'id'       => (string) $plan->id,
    //                     'price'    => (int) $transaction->total_amount,
    //                     'quantity' => 1,
    //                     'name'     => $plan->title,
    //                 ],
    //             ],
    //         ];

    //         // 3. Minta Snap Token dari Midtrans
    //         $snapToken = Snap::getSnapToken($params);

    //         // 4. Update Token ke DB
    //         $transaction->update([
    //             'midtrans_snap_token' => $snapToken,
    //         ]);

    //         // 5. Return JSON sesuai ekspektasi JavaScript di Blade (data.snap_token)
    //         return response()->json([
    //             'status'     => 'success',
    //             'snap_token' => $snapToken,
    //         ]);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function purchase(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        try {
            $plan = Plan::findOrFail($request->plan_id);

            // Hitung harga resmi + pajak 10% di server-side (mencegah price tampering)
            $totalAmount = (int) round($plan->price * 1.10);

            $referenceNumber = 'PAY-' . date('Ymd') . '-' . time() . '-' . $user->id;

            // Bungkus dalam Database Transaction
            $snapToken = DB::transaction(function () use ($user, $plan, $totalAmount, $referenceNumber) {

                // 1. Simpan Transaksi Ke Database
                $transaction = Payment::query()->create([
                    'user_id'             => $user->id,
                    'plan_id'             => $plan->id,
                    'transaction_number'  => $referenceNumber,
                    'total_amount'        => $totalAmount,
                    'status'              => 'pending',
                    'midtrans_snap_token' => null,
                ]);

                // 2. Buat Payload Midtrans Snap
                $params = [
                    'transaction_details' => [
                        'order_id'     => $transaction->transaction_number,
                        'gross_amount' => $totalAmount,
                    ],
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email'      => $user->email,
                    ],
                    'item_details' => [
                        [
                            'id'       => (string) $plan->id,
                            'price'    => $totalAmount,
                            'quantity' => 1,
                            'name'     => substr($plan->title, 0, 50), // Batas maksimal karakter Midtrans
                        ],
                    ],
                ];

                // 3. Minta Snap Token dari Midtrans
                $token = Snap::getSnapToken($params);

                // 4. Update Token ke DB
                $transaction->update([
                    'midtrans_snap_token' => $token,
                ]);

                return $token;
            });

            // 5. Response JSON sukses
            return response()->json([
                'status'     => 'success',
                'snap_token' => $snapToken,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
