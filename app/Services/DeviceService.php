<?php

namespace App\Services;

use App\Models\User;
use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;

interface DeviceService
{
    public function registerDevice(User $user, string $deviceId): Device;

    public function removeDevice(Device $device): bool;

    public function countUserDevice(User $user): int;

    public function getAllUserDevices(User $user): Collection;

    public function getValidDevice();
}
