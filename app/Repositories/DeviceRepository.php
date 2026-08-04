<?php

namespace App\Repositories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

interface DeviceRepository
{
    public function updateOrCreate(array $attribute, array $value): Device;

    public function delete(Device $userDevice): bool;

    public function countUserDevice(User $user): int;

    public function getAllUserDevices(User $user): Collection;

    public function getValidDevice(User $user, string $id);
}
