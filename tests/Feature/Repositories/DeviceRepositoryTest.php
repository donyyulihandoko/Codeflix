<?php

namespace Tests\Feature\Repositories;

use App\Models\Device;
use App\Models\User;
use App\Repositories\DeviceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\TestCase;
use Jenssegers\Agent\Facades\Agent;

class DeviceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private DeviceRepository $deviceRepository;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->deviceRepository = $this->app->make(DeviceRepository::class);
    }

    public function test_service_container_not_null()
    {
        $this->assertNotNull($this->deviceRepository);
    }

    public function test_create_or_update()
    {
        $attribute = [
            'user_id' => User::factory()->create()->id,
            'device_id' => uniqid()
        ];

        $values = [
            'device_name' => ucfirst(Agent::platform() . ' ' . Agent::browser()),
            'device_type' => Agent::isDesktop() ? 'desktop' : (Agent::isPhone() ? 'phone' : 'tablet'),
            'platform' => Agent::platform(),
            'platform_version' => Agent::version(Agent::platform()),
            'browser' => Agent::browser(),
            'browser_version' => Agent::version(Agent::browser()),
            'last_active' => now(),
        ];

        $setDevice = $this->deviceRepository->updateOrCreate($attribute, $values);

        $this->assertNotNull($setDevice);
        $this->assertDatabaseHas('devices', [
            'id' => $setDevice->id,
            'user_id' => $setDevice->user->id,
            'device_id' => $setDevice->device_id
        ]);
    }

    public function test_delete_device()
    {
        $user = User::factory()->create();
        Device::factory(3)->create(['user_id' => $user->id]);
        $devices = $this->deviceRepository->getAllUserDevices($user);

        foreach($devices as $index => $device){
            if($index === 0)
            $this->deviceRepository->delete($device);
        }

        $this->assertDatabaseMissing('devices', [
            'id' => $devices->first()->id
        ]);

    }

    public function test_get_all_user_devices()
    {
        $user = User::factory()->create();
        Device::factory(4)->create(['user_id' => $user]);

        $devices = $this->deviceRepository->getAllUserDevices($user);

        $this->assertNotNull($devices);
        $this->assertCount(4, $devices);

    }

    public function test_get_valid_device()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        session(['device_id' => $device->id]);

        $result = $this->deviceRepository->getValidDevice($user, session('device_id'));

        $this->assertNotNull($result);
    }


}
