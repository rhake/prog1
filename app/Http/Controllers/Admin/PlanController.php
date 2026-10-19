<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::query()->withCount([
            'subscriptions as active_subscriptions_count' => fn ($query) => $query->where('status', 'active'),
        ])->orderBy('monthly_price')->get();

        $subscriptions = Subscription::query()
            ->with(['user', 'vehicle', 'plan'])
            ->latest('start_date')
            ->get();

        return view('admin.plans', compact('plans', 'subscriptions'));
    }
}
