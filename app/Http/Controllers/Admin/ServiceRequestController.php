<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceChecklistItem;
use App\Models\ServiceHistory;
use App\Models\ServicePhoto;
use App\Models\ServiceRequest;
use App\Support\ServiceVisitFiles;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->ensureChecklist();
        $serviceRequest->load(['user', 'vehicle', 'garage', 'service', 'photos', 'checklistItems']);

        return view('admin.services-show', ['item' => $serviceRequest]);
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

    public function updateVisit(Request $request, ServiceRequest $serviceRequest)
    {
        $data = $request->validate([
            'arrived_at' => ['nullable', 'date'],
            'departed_at' => ['nullable', 'date', 'after_or_equal:arrived_at'],
            'provider_notes' => ['nullable', 'string', 'max:4000'],
        ]);

        $serviceRequest->update($data);

        return back()->with('success', __('Horários e anotações salvos.'));
    }

    public function storeInvoice(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'invoice' => ['required', 'file', 'max:8192', 'mimes:pdf,jpg,jpeg,png,webp,svg'],
        ]);

        ServiceVisitFiles::deletePath($serviceRequest->invoice_path);

        $file = $request->file('invoice');
        $originalName = $file->getClientOriginalName();
        $path = ServiceVisitFiles::store($serviceRequest, $file, 'nf');

        $serviceRequest->update([
            'invoice_path' => $path,
            'invoice_name' => $originalName,
        ]);

        return back()->with('success', __('Nota fiscal anexada.'));
    }

    public function storePhoto(Request $request, ServiceRequest $serviceRequest)
    {
        $data = $request->validate([
            'kind' => ['required', Rule::in(ServicePhoto::KINDS)],
            'caption' => ['nullable', 'string', 'max:180'],
            'photos' => ['required', 'array', 'min:1', 'max:8'],
            'photos.*' => ['file', 'max:4096', 'mimes:jpg,jpeg,png,webp,svg,gif'],
        ]);

        foreach ($request->file('photos', []) as $file) {
            $serviceRequest->photos()->create([
                'kind' => $data['kind'],
                'path' => ServiceVisitFiles::store($serviceRequest, $file, $data['kind']),
                'caption' => $data['caption'] ?: null,
            ]);
        }

        return back()->with('success', __('Fotos anexadas.'));
    }

    public function destroyPhoto(ServiceRequest $serviceRequest, ServicePhoto $photo)
    {
        abort_unless($photo->service_request_id === $serviceRequest->id, 404);

        ServiceVisitFiles::deletePhoto($photo);

        return back()->with('success', __('Foto removida.'));
    }

    public function updateChecklist(Request $request, ServiceRequest $serviceRequest)
    {
        $serviceRequest->ensureChecklist();

        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.status' => ['required', Rule::in(ServiceChecklistItem::STATUSES)],
            'items.*.notes' => ['nullable', 'string', 'max:255'],
        ]);

        $allowed = $serviceRequest->checklistItems()->pluck('id')->all();

        foreach ($data['items'] as $id => $item) {
            if (! in_array((int) $id, $allowed, true)) {
                continue;
            }

            ServiceChecklistItem::query()->whereKey($id)->update([
                'status' => $item['status'],
                'notes' => $item['notes'] ?: null,
            ]);
        }

        return back()->with('success', __('Check-list atualizado.'));
    }
}
