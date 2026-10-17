<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGarageRequest;
use App\Models\Garage;

class GarageController extends Controller
{
    public function index()
    {
        $garages = Garage::query()->orderBy('name')->get();

        return view('admin.garages', compact('garages'));
    }

    public function store(StoreGarageRequest $request)
    {
        Garage::create($request->validated());

        return back()->with('success', __('Oficina cadastrada.'));
    }

    public function destroy(Garage $garage)
    {
        if ($garage->serviceRequests()->exists()) {
            return back()->with('error', __('Esta oficina possui serviços vinculados.'));
        }

        $garage->delete();

        return back()->with('success', __('Oficina removida.'));
    }
}
