<?php

namespace App\Repositories\Impl;

use App\Repositories\DeviceRepository;
use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use Override;

class DeviceRepositoryImpl implements DeviceRepository
{
    #[Override]
    public function updateOrCreate(array $attribute, array $value): Device
    {
        return Device::updateOrCreate($attribute, $value);
    }

    public function delete(Device $device): bool
    {
        if (session('device_id') === $device->device_id) {
        session()->forget('device_id');
         }
        return $device->delete();
    }

    #[Override]
    public function countUserDevice(User $user): int
    {
        return $user->devices()->count();
    }

    public function getAllUserDevices(User $user): Collection
    {
        return $user->devices()->latest()->get();
    }

    public function getValidDevice(User $user, string $id)
    {
        return $user->devices()->where('device_id', $id)->exists();
    }

}
