<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequestRequest;
use App\Models\Garage;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = $request->user()->serviceRequests()
            ->with(['garage', 'vehicle'])
            ->latest()
            ->get();

        return view('app.services.index', ['requests' => $requests]);
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $this->authorize('view', $serviceRequest);

        $serviceRequest->ensureChecklist();
        $serviceRequest->load(['garage', 'vehicle', 'service', 'photos', 'checklistItems']);

        return view('app.services.show', ['item' => $serviceRequest]);
    }

    public function create(Request $request)
    {
        $vehicles = $request->user()->vehicles()->orderBy('brand')->get();
        $services = Service::query()->orderBy('service_name')->get();
        $garages = Garage::query()->orderByDesc('rating')->get();

        return view('app.services.create', compact('vehicles', 'services', 'garages'));
    }

    public function store(StoreServiceRequestRequest $request)
    {
        $vehicle = Vehicle::query()
            ->where('user_id', $request->user()->id)
            ->findOrFail($request->integer('vehicle_id'));
        $service = Service::query()->findOrFail($request->integer('service_id'));
        $garage = Garage::query()->findOrFail($request->integer('garage_id'));

        $serviceRequest = $request->user()->serviceRequests()->create([
            'vehicle_id' => $vehicle->id,
            'service_id' => $service->id,
            'garage_id' => $garage->id,
            'service_type' => $service->service_name,
            'description' => $request->input('description') ?: $service->service_name,
            'status' => 'pending',
            'scheduled_date' => $request->date('scheduled_date'),
        ]);
        $serviceRequest->ensureChecklist();

        $request->user()->alerts()->create([
            'type' => 'service_update',
            'message' => __('Solicitação de :service enviada para :garage.', [
                'service' => $service->service_name,
                'garage' => $garage->name,
            ]),
            'read_status' => false,
        ]);

        return redirect()->route('app.services.show', $serviceRequest)->with('success', __('Serviço solicitado.'));
    }

    public function cancel(Request $request, ServiceRequest $serviceRequest)
    {
        $this->authorize('update', $serviceRequest);

        if (! in_array($serviceRequest->status, ['pending', 'accepted'], true)) {
            return back()->with('error', __('Este serviço não pode mais ser cancelado.'));
        }

        $serviceRequest->update(['status' => 'cancelled']);

        return back()->with('success', __('Solicitação cancelada.'));
    }
}
