<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = $request->user()->vehicles()
            ->with(['activeSubscription.plan'])
            ->latest()
            ->get();

        return view('app.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('app.vehicles.create');
    }

    public function store(StoreVehicleRequest $request)
    {
        $request->user()->vehicles()->create($request->validated());

        return redirect()->route('app.vehicles.index')->with('success', __('Veículo cadastrado.'));
    }

    public function show(Request $request, Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        $vehicle->load(['histories.service', 'histories.garage', 'device']);
        $subscription = $vehicle->subscriptions()->where('status', 'active')->with('plan')->latest('id')->first();

        return view('app.vehicles.show', compact('vehicle', 'subscription'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $data = $request->validate([
            'mileage' => ['required', 'integer', 'min:0', 'max:2000000'],
        ]);

        $vehicle->update($data);

        return back()->with('success', __('Quilometragem atualizada.'));
    }
}
