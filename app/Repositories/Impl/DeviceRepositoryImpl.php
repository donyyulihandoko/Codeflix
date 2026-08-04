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

}
