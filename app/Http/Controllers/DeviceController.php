<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\DeviceService;
use Illuminate\Http\RedirectResponse;


class DeviceController extends Controller
{
    public function __construct(private DeviceService $deviceService, private SubscriptionService $subscriptionService)
    {
        //
    }

    public function index(Request $request): Response
    {
        $user = $request->user();
        $devices = $this->deviceService->getAllUserDevices($user);

        $subscription = $this->subscriptionService->getCurrentSubscriptionPlan($user);
        $maxDevice = ($subscription && $subscription->plan) ? $subscription->plan->max_devices : 1;

        return response()->view('devices.index', [
            'devices' => $devices,
            'maxDevice' => $maxDevice
        ]);
    }

    public function destroy(Device $userDevice): RedirectResponse
    {
        $this->deviceService->removeDevice($userDevice);
        return redirect()->back()->with('success', 'Perangkat berhasil dihapus. Kuota menonton kamu sudah diperbarui.');
    }
}
