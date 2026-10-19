<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        $vehicleCount = $user->vehicles()->count();
        $subscriptionCount = $user->subscriptions()->where('status', 'active')->count();

        return view('app.profile', compact('user', 'vehicleCount', 'subscriptionCount'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->safe()->only(['name', 'phone', 'address', 'email']);

        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
        }

        $user->update($data);

        return back()->with('success', __('Perfil atualizado.'));
    }
}
