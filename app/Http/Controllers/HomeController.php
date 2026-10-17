<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class HomeController extends Controller
{
    public function index()
    {
        $plans = Plan::query()->orderBy('monthly_price')->get();

        return view('home', compact('plans'));
    }
}
