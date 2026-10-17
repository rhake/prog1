<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request, string $locale)
    {
        if (in_array($locale, ['pt', 'en'], true)) {
            $request->session()->put('locale', $locale);
        }

        return redirect()->back(fallback: route('home'));
    }
}
