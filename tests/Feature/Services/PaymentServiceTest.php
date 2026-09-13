<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\PaymentService;
use App\Models\Plan;
use App\Models\User;
use App\Models\Payment;
use Midtrans\Snap;
use Mockery;
use Exception;
use Midtrans\Config as MidtransConfig;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'midtrans.server_key' => 'SB-Mid-server-dummy-key-12345',
            'midtrans.is_production' => false,
            'midtrans.is_sanitized' => true,
            'midtrans.is_3ds' => true,
        ]);

        MidtransConfig::$serverKey = 'SB-Mid-server-dummy-key-12345';
        MidtransConfig::$isProduction = false;

        $this->paymentService = $this->app->make(PaymentService::class);
    }

    public function test_service_container_not_null()
    {
        $this->assertNotNull($this->paymentService);
    }
    public function test_purchase_successfully_creates_payment_and_returns_snap_token(): void
    {
        // 1. Arrange
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        $this->actingAs($user);

        $plan = Plan::factory()->create([
            'title' => 'VIP Monthly Plan',
            'price' => 150000,
        ]);

        // Mock method static Midtrans\Snap::getSnapToken
        $snapMock = Mockery::mock('alias:' . Snap::class);
        $snapMock->shouldReceive('getSnapToken')
            ->once()
            ->andReturn('mocked-snap-token-xyz-123');

        // 2. Act (Gunakan service instance asli dari container)
        $payment = $this->paymentService->purchase($plan);

        // 3. Assertions
        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals('mocked-snap-token-xyz-123', $payment->midtrans_snap_token);
        $this->assertStringStartsWith('PAY-', $payment->transaction_number);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'total_amount' => 150000,
            'status' => 'pending',
            'midtrans_snap_token' => 'mocked-snap-token-xyz-123',
        ]);
    }

    public function test_purchase_rolls_back_transaction_when_snap_token_generation_fails(): void
    {
        // 1. Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $plan = Plan::factory()->create(['price' => 100000]);

        // Mock Midtrans\Snap untuk melemparkan Exception
        $snapMock = Mockery::mock('alias:' . Snap::class);
        $snapMock->shouldReceive('getSnapToken')
            ->once()
            ->andThrow(new Exception('Midtrans Error: Access Denied'));

        // 2. Expect Exception & Act
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Midtrans Error: Access Denied');

        try {
            $this->paymentService->purchase($plan);
        } finally {
            // 3. Assert: DB Rollback berhasil
            $this->assertDatabaseCount('payments', 0);
        }
    }

    public function test_get_payment_by_transaction_number()
    {
        $payment = Payment::factory()->create();
        $retrievedPayment = $this->paymentService->getPaymentByTransactionNumber($payment->transaction_number);

        $this->assertNotNull($retrievedPayment);
        $this->assertEquals($payment->id, $retrievedPayment->id);
        $this->assertEquals($payment->transaction_number, $retrievedPayment->transaction_number);
    }

    public function test_update_payment()
    {
        $payment = Payment::factory()->create([
            'status' => 'completed',
        ]);

        $updateData = [
            'total_amount' => $this->faker->randomFloat(2, 10, 100),
            'status' => 'pending',
        ];

        $result = $this->paymentService->updatePayment($payment, $updateData);

        $this->assertTrue($result);
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'total_amount' => $updateData['total_amount'],
            'status' => $updateData['status'],
        ]);
    }
}



