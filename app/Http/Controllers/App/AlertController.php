<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $alerts = $request->user()->alerts()->latest()->get();

        return view('app.alerts', compact('alerts'));
    }

    public function read(Request $request, Alert $alert)
    {
        abort_unless($alert->user_id === $request->user()->id, 403);

        $alert->update(['read_status' => true]);

        return back();
    }

    public function readAll(Request $request)
    {
        $request->user()->alerts()->where('read_status', false)->update(['read_status' => true]);

        return back()->with('success', __('Notificações marcadas como lidas.'));
    }
}
