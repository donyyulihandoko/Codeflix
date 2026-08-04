<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Models\Device;
use App\Repositories\DeviceRepository;
use App\Services\DeviceService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Override;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DeviceServiceImpl implements DeviceService
{
    public function __construct(private DeviceRepository $deviceRepository)
    {
        //
    }

    #[Override]
    public function registerDevice(User $user, string $deviceId): Device
    {
        $attribute = [
            'user_id' => $user->id,
            'device_id' => $deviceId
        ];

        $deviceInfo = $this->generateDeviceInfo();

        $values = [
            'device_name' => $deviceInfo['device_name'],
            'device_type' => $deviceInfo['device_type'],
            'platform' => $deviceInfo['platform'],
            'platform_version' => $deviceInfo['platform_version'],
            'browser' => $deviceInfo['browser'],
            'browser_version' => $deviceInfo['browser_version'],
            'last_active' => now(),
        ];

       // 1. Simpan/Update data perangkat ke database
        $device = $this->deviceRepository->updateOrCreate($attribute, $values);

        // 2. Simpan device_id ke session user saat ini
        session(['device_id' => $device->device_id]);

        return $device;

    }

    #[Override]
    public function removeDevice(Device $device): bool
    {
        if(session('id') === $device->device_id) {
            session()->flush('device_id');
        }
        return  $this->deviceRepository->delete($device);
    }

    private function generateDeviceInfo(): array
    {
        return [
            'device_name' => ucfirst(Agent::platform() . ' ' . Agent::browser()),
            'device_type' => Agent::isDesktop() ? 'desktop' : (Agent::isPhone() ? 'phone' : 'tablet'),
            'platform' => Agent::platform(),
            'platform_version' => Agent::version(Agent::platform()),
            'browser' => Agent::browser(),
            'browser_version' => Agent::version(Agent::browser()),
        ];
    }

    #[Override]
    public function countUserDevice(User $user): int
    {
        return $this->deviceRepository->countUserDevice($user);
    }

    #[Override]
    public function getAllUserDevices(User $user): Collection
    {
        return $this->deviceRepository->getAllUserDevices($user);
    }

}
