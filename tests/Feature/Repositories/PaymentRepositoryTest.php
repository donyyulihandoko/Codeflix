<?php

namespace Tests\Feature\Repositories;

use App\Repositories\PaymentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Plan;
use App\Models\User;
use App\Models\Payment;

class PaymentRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private PaymentRepository $paymentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentRepository = $this->app->make(PaymentRepository::class);
    }

    public function test_service_container_not_null()
    {
        $this->assertNotNull($this->paymentRepository);
    }

    public function test_create_payment()
    {
        $data = [
            'user_id' => User::factory()->create()->id,
            'plan_id' => Plan::factory()->create()->id,
            'transaction_number' => $this->faker->uuid,
            'total_amount' => $this->faker->randomFloat(2, 10, 100),
            'status' => 'completed',
        ];

        $payment = $this->paymentRepository->create($data);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'user_id' => $data['user_id'],
            'plan_id' => $data['plan_id'],
            'transaction_number' => $data['transaction_number'],
            'total_amount' => $data['total_amount'],
            'status' => $data['status'],
        ]);
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

        $result = $this->paymentRepository->updatePayment($payment, $updateData);

        $this->assertTrue($result);
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'total_amount' => $updateData['total_amount'],
            'status' => $updateData['status'],
        ]);
    }

    public function test_get_payment_by_transaction_number()
    {
        $payment = Payment::factory()->create();

        $retrievedPayment = $this->paymentRepository->getPaymentByTransactionNumber($payment->transaction_number);

        $this->assertNotNull($retrievedPayment);
        $this->assertEquals($payment->id, $retrievedPayment->id);
        $this->assertEquals($payment->transaction_number, $retrievedPayment->transaction_number);
    }
}
