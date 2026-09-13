<?php

namespace Tests\Feature\Services;

use App\Models\Device;
use App\Services\DeviceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use App\Models\User;
use Jenssegers\Agent\Facades\Agent;

use Tests\TestCase;

class DeviceServiceTest extends TestCase
{
    use RefreshDatabase;

    private DeviceService $deviceService;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->deviceService = $this->app->make(DeviceService::class);
    }

    public function test_register_device()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create(['user_id' => $user->id]);

        $setDevice = $this->deviceService->registerDevice($user, $device);

        $this->assertNotNull($setDevice);
        $this->assertDatabaseHas('devices', [
            'id' => $setDevice->id,
            'user_id' => $setDevice->user->id,
            'device_id' => $setDevice->device_id
        ]);
    }

    public function test_remove_device()
    {
        $user = User::factory()->create();
        Device::factory(3)->create(['user_id' => $user->id]);
        $devices = $this->deviceService->getAllUserDevices($user);

        foreach($devices as $index => $device){
            if($index === 0)
            $this->deviceService->removeDevice($device);
        }

        $this->assertDatabaseMissing('devices', [
            'id' => $devices->first()->id
        ]);
    }

    public function test_get_all_user_devices()
    {
        $user = User::factory()->create();
        Device::factory(4)->create(['user_id' => $user]);

        $devices = $this->deviceService->getAllUserDevices($user);

        $this->assertNotNull($devices);
        $this->assertCount(4, $devices);
    }

    public function test_valid_device()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create(['user_id' => $user->id]);
        session(['device_id' => $device->id]);
        $this->actingAs($user);

        $result = $this->deviceService->getValidDevice();
        $this->assertNotNull($result);
    }
}
