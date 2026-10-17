<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $vehicles = $user->vehicles()->latest()->get();
        $primary = $vehicles->first();
        $subscription = $primary?->subscriptions()->where('status', 'active')->with('plan')->latest('id')->first();
        $activeService = $user->serviceRequests()
            ->whereIn('status', ['pending', 'accepted', 'in_progress'])
            ->latest()
            ->first();
        $unread = $user->alerts()->where('read_status', false)->latest()->get();

        return view('app.home', compact('user', 'vehicles', 'primary', 'subscription', 'activeService', 'unread'));
    }
}
