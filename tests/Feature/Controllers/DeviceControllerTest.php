<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Override;
use App\Http\Middleware\CheckDeviceSessionMiddleware;
use App\Http\Middleware\CheckSubscriptionMiddleware;
use App\Models\Device;
use App\Models\Plan;
use App\Models\Subscription;

class DeviceControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_member1()->create());
        $this->withoutMiddleware([CheckDeviceSessionMiddleware::class]);
    }

    public function test_index_displays_user_devices_and_plan_max_devices(): void
    {
        // 1. Arrange: User dengan paket berlangganan 5 device
        $user = User::factory()->create();
        $plan = Plan::factory()->create(['max_devices' => 5]);

        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'active' => true
        ]);

        // Buat 2 device milik user
        $devices = Device::factory()->count(2)->create(['user_id' => $user->id]);

        // 2. Act
        $response = $this->actingAs($user)->get(route('devices.index'));

        // 3. Assert
        $response->assertOk()
            ->assertViewIs('devices.index')
            ->assertViewHas('devices', function ($viewDevices) use ($devices) {
                return $viewDevices->count() === 2
                    && $viewDevices->pluck('id')->diff($devices->pluck('id'))->isEmpty();
            })
            ->assertViewHas('maxDevice', 5);
    }

    public function test_destroy()
    {
        $device = Device::factory()->create();
        $response = $this->delete(route('devices.destroy', $device));

        $response->assertStatus(302)
            ->assertRedirectBack()
            ->assertSessionHas('success', 'Perangkat berhasil dihapus. Kuota menonton kamu sudah diperbarui.');
    }


    // public function test_destroy_failed_data_not_found(): void
    // {
    //     // 1. Arrange: Buat user dan login
    //     $user = User::factory()->create();

    //     // 2. Act: Gunakan from() untuk menyimulasikan URL asal request
    //     $response = $this->actingAs($user)
    //         ->from(route('devices.index'))
    //         ->delete(route('devices.destroy', 99999)); // Gunakan ID dummy yang dipastikan tidak ada

    //     // 3. Assert
    //     $response
    //         ->assertRedirect(route('devices.index')) // Atau pakai ->assertRedirectBack()
    //         ->assertSessionHas('error', 'Something went wrong on our end. Contact support if the issue persists.');
    // }
}
