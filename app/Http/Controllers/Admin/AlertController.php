<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlertRequest;
use App\Models\Alert;
use App\Models\User;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::query()->with('user')->latest()->get();
        $users = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.alerts', compact('alerts', 'users'));
    }

    public function store(StoreAlertRequest $request)
    {
        Alert::create([
            ...$request->validated(),
            'read_status' => false,
        ]);

        return back()->with('success', __('Notificação enviada.'));
    }
}
