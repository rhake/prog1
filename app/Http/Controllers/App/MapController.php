<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $devices = $request->user()->devices()->with('vehicle')->latest('last_update')->get();

        return view('app.map', compact('devices'));
    }
}
