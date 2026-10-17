<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $current = $request->cookie('theme', 'dark');
        $next = $current === 'light' ? 'dark' : 'light';

        return redirect()->back(fallback: route('home'))->cookie('theme', $next, 60 * 24 * 365);
    }
}
