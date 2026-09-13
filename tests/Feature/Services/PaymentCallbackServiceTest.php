<?php

namespace Tests\Feature\Services;

use App\Services\PaymentCallbackService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\TestCase;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;

class PaymentCallbackServiceTest extends TestCase
{
    use RefreshDatabase;

    private PaymentCallbackService $callbackService;
    private string $serverKey = 'SB-Mid-server-dummy-key-12345';

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        // 1. Set Config ServerKey agar sesuai dengan helper signature
        config(['midtrans.server_key' => $this->serverKey]);

        // 2. Resolve Service dari Container
        $this->callbackService = $this->app->make(PaymentCallbackService::class);
    }

    /** Helper untuk membuat signature key SHA512 valid */
    private function generateSignatureKey(string $orderId, string $statusCode, string $grossAmount): string
    {
        return hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);
    }

    public function test_handle_callback_success_settlement(): void
    {
        // Arrange
        $user = User::factory()->create();
        $plan = Plan::factory()->create(['duration' => 30]);
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'transaction_number' => 'TRX-12345',
            'status' => 'pending',
            'total_amount' => 100000,
        ]);

        $payload = [
            'order_id' => 'TRX-12345',
            'status_code' => '200',
            'gross_amount' => '100000',
            'transaction_status' => 'settlement',
            'payment_type' => 'gopay',
            'signature_key' => $this->generateSignatureKey('TRX-12345', '200', '100000'),
        ];

        // Act
        $response = $this->callbackService->handleCallbackPayment($payload);

        // Assert Response
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('success', $response['body']['status']);

        // Assert Database Payment Updated
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'success',
            'payment_type' => 'gopay',
        ]);

        // Assert Database Subscription Created
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'active' => true,
        ]);
    }

    public function test_handle_callback_returns_400_when_signature_is_invalid(): void
    {
        $payload = [
            'order_id' => 'TRX-12345',
            'status_code' => '200',
            'gross_amount' => '100000',
            'transaction_status' => 'settlement',
            'signature_key' => 'invalid-signature-hash',
        ];

        $response = $this->callbackService->handleCallbackPayment($payload);

        $this->assertEquals(400, $response['code']);
        $this->assertEquals('Invalid signature key', $response['body']['message']);
    }

    public function test_handle_callback_returns_404_when_payment_not_found(): void
    {
        $payload = [
            'order_id' => 'NON-EXISTENT-ORDER',
            'status_code' => '200',
            'gross_amount' => '100000',
            'transaction_status' => 'settlement',
            'signature_key' => $this->generateSignatureKey('NON-EXISTENT-ORDER', '200', '100000'),
        ];

        $response = $this->callbackService->handleCallbackPayment($payload);

        $this->assertEquals(404, $response['code']);
        $this->assertEquals('Payment not found', $response['body']['message']);
    }

    public function test_handle_callback_idempotency_when_already_success(): void
    {
        // Payment sudah berstatus success sebelumnya
        $payment = Payment::factory()->create([
            'transaction_number' => 'TRX-ALREADY-SUCCESS',
            'status' => 'success',
            'total_amount' => 50000,
        ]);

        $payload = [
            'order_id' => $payment->transaction_number,
            'status_code' => '200',
            'gross_amount' => '50000',
            'transaction_status' => 'settlement',
            'signature_key' => $this->generateSignatureKey($payment->transaction_number, '200', '50000'),
        ];

        $response = $this->callbackService->handleCallbackPayment($payload);

        $this->assertEquals(200, $response['code']);
        $this->assertEquals('Payment already processed', $response['body']['message']);
    }

    public function test_handle_callback_failed_status_expire_or_cancel(): void
    {
        $payment = Payment::factory()->create([
            'transaction_number' => 'TRX-EXPIRED',
            'status' => 'pending',
            'total_amount' => 50000,
        ]);

        $payload = [
            'order_id' => $payment->transaction_number,
            'status_code' => '202',
            'gross_amount' => '50000',
            'transaction_status' => 'expire',
            'signature_key' => $this->generateSignatureKey($payment->transaction_number, '202', '50000'),
        ];

        $response = $this->callbackService->handleCallbackPayment($payload);

        $this->assertEquals(200, $response['code']);
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'failed',
        ]);
    }
}
