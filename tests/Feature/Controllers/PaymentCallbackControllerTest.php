<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\CheckDeviceSessionMiddleware;
use App\Models\User;
use App\Services\PaymentCallbackService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery\MockInterface;
use Override;
use Tests\TestCase;

class PaymentCallbackControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->is_member1()->create());
        $this->withoutMiddleware([CheckDeviceSessionMiddleware::class]);
    }

    public function test_invoke_handles_callback_successfully(): void
    {
        // 1. Arrange
        $payload = [
            'order_id' => 'PAY-123456',
            'transaction_status' => 'settlement',
            'status_code' => '200',
            'gross_amount' => '150000.00',
            'signature_key' => 'dummy-signature-hash',
        ];

        $this->mock(PaymentCallbackService::class, function (MockInterface $mock) use ($payload) {
            $mock->shouldReceive('handleCallbackPayment')
                ->once()
                ->with($payload)
                ->andReturn([
                    'code' => 200,
                    'body' => [
                        'status' => 'success',
                        'message' => 'Payment updated successfully',
                    ],
                ]);
        });

        // 2. Act: Gunakan nama route ber-prefix api.
        $response = $this->postJson(route('api.payments.callback'), $payload);

        // 3. Assert
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Payment updated successfully',
            ]);
    }

    public function test_invoke_logs_error_when_service_throws_exception(): void
    {
        // 1. Arrange
        $payload = ['order_id' => 'PAY-INVALID'];

        Log::shouldReceive('error')
            ->once()
            ->with('Error PaymentCallbackControllerInvalid signature key');

        $this->mock(PaymentCallbackService::class, function (MockInterface $mock) use ($payload) {
            $mock->shouldReceive('handleCallbackPayment')
                ->once()
                ->with($payload)
                ->andThrow(new Exception('Invalid signature key'));
        });

        // 2. Act: Gunakan nama route ber-prefix api.
        $response = $this->postJson(route('api.payments.callback'), $payload);

        // 3. Assert
        $response->assertStatus(200);
    }
}
