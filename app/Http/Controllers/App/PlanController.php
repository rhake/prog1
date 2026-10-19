<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = Plan::query()->orderBy('monthly_price')->get();
        $vehicles = $request->user()->vehicles()->with('activeSubscription')->orderBy('brand')->get();
        $activePlanIds = $vehicles
            ->map(fn (Vehicle $vehicle) => $vehicle->activeSubscription?->plan_id)
            ->filter()
            ->unique()
            ->values();

        return view('app.plans', compact('plans', 'vehicles', 'activePlanIds'));
    }

    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'plan_id' => ['required', 'integer', 'exists:plans,id'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
        ]);

        $vehicle = Vehicle::query()
            ->where('user_id', $request->user()->id)
            ->findOrFail($data['vehicle_id']);
        $plan = Plan::query()->findOrFail($data['plan_id']);

        $vehicle->subscriptions()->where('status', 'active')->update(['status' => 'cancelled']);

        $subscription = Subscription::create([
            'user_id' => $request->user()->id,
            'vehicle_id' => $vehicle->id,
            'plan_id' => $plan->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
            'renewal_date' => now()->addMonth()->toDateString(),
            'status' => 'active',
        ]);

        Payment::create([
            'user_id' => $request->user()->id,
            'subscription_id' => $subscription->id,
            'amount' => $plan->monthly_price,
            'payment_method' => 'pix',
            'payment_status' => 'paid',
            'payment_date' => now()->toDateString(),
        ]);

        $request->user()->alerts()->create([
            'type' => 'payment',
            'message' => __('Plano :plan ativado para :vehicle. Pagamento simulado via PIX.', [
                'plan' => $plan->plan_name,
                'vehicle' => $vehicle->label(),
            ]),
            'read_status' => false,
        ]);

        return redirect()->route('app.plans')->with('success', __('Assinatura ativada.'));
    }
}
