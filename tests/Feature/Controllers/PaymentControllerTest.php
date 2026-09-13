<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\CheckDeviceSessionMiddleware;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use App\Services\PaymentService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery\MockInterface;
use Override;
use Mockery;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_member1()->create());
        $this->withoutMiddleware(CheckDeviceSessionMiddleware::class);
    }

    public function test_purchase_returns_snap_token_successfully(): void
    {
        // 1. Arrange
        $plan = Plan::factory()->create(['title' => 'VIP Monthly Plan', 'price' => 150000]);

        $payment = Payment::factory()->make([
            'midtrans_snap_token' => 'mocked-snap-token-xyz-123',
        ]);

        $this->mock(PaymentService::class, function (MockInterface $mock) use ($plan, $payment) {
            $mock->shouldReceive('purchase')
                ->once()
                ->with(Mockery::on(fn($p) => $p->id === $plan->id))
                ->andReturn($payment);
        });

        // 2. Act
        $response = $this->postJson(route('payments.purchase', $plan));

        // 3. Assert
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'midtrans_snap_token' => 'mocked-snap-token-xyz-123',
            ]);
    }

    public function test_purchase_returns_500_and_logs_error_on_failure(): void
    {
        // 1. Arrange
        $plan = Plan::factory()->create(['price' => 100000]);

        Log::shouldReceive('error')
            ->once()
            ->with('Payment Purchase Error: Midtrans Connection Timeout');

        $this->mock(PaymentService::class, function (MockInterface $mock) use ($plan) {
            $mock->shouldReceive('purchase')
                ->once()
                ->with(Mockery::on(fn($p) => $p->id === $plan->id))
                ->andThrow(new Exception('Midtrans Connection Timeout'));
        });

        // 2. Act
        $response = $this->postJson(route('payments.purchase', $plan));

        // 3. Assert
        $response->assertStatus(500)
            ->assertJson([
                'status' => 'error',
                'message' => 'Midtrans Connection Timeout',
            ]);
    }

}
