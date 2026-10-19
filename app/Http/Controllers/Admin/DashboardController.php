<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Payment;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::query()->count();
        $vehicles = Vehicle::query()->count();
        $pending = ServiceRequest::query()->where('status', 'pending')->count();
        $revenue = (float) Payment::query()->where('payment_status', 'paid')->sum('amount');
        $recent = ServiceRequest::query()->with('user')->latest()->limit(5)->get();
        $devices = Device::query()->latest('last_update')->get();

        return view('admin.dashboard', compact('users', 'vehicles', 'pending', 'revenue', 'recent', 'devices'));
    }
}
