<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceHistory;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $requests = ServiceRequest::query()
            ->with(['user', 'vehicle', 'garage', 'service'])
            ->latest()
            ->get();

        return view('admin.services', ['requests' => $requests]);
    }

    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        $status = $request->validate([
            'status' => ['required', 'in:accepted,denied,in_progress,completed,cancelled'],
        ])['status'];

        $allowed = [
            'pending' => ['accepted', 'denied', 'cancelled'],
            'accepted' => ['in_progress', 'cancelled'],
            'in_progress' => ['completed', 'cancelled'],
        ];

        if (! in_array($status, $allowed[$serviceRequest->status] ?? [], true)) {
            return back()->with('error', __('Transição de status inválida.'));
        }

        $serviceRequest->update(['status' => $status]);

        if ($status === 'completed') {
            ServiceHistory::create([
                'vehicle_id' => $serviceRequest->vehicle_id,
                'service_id' => $serviceRequest->service_id,
                'garage_id' => $serviceRequest->garage_id,
                'service_date' => now()->toDateString(),
                'cost' => $serviceRequest->service?->average_price ?? 0,
                'notes' => $serviceRequest->description,
            ]);
        }

        $serviceRequest->user?->alerts()->create([
            'type' => 'service_update',
            'message' => __('Seu serviço :service foi atualizado para :status.', [
                'service' => $serviceRequest->service_type,
                'status' => \App\Support\Labels::status($status)[0],
            ]),
            'read_status' => false,
        ]);

        return back()->with('success', __('Serviço atualizado.'));
    }
}
