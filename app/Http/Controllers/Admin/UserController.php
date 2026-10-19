<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $users = User::query()
            ->withCount('vehicles')
            ->with(['subscriptions' => fn ($query) => $query->where('status', 'active')->with('plan')])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();

        return view('admin.users', compact('users', 'search'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,inactive,suspended'],
        ]);

        if ($user->id === $request->user()->id && $data['status'] !== 'active') {
            return back()->with('error', __('Você não pode desativar a própria conta.'));
        }

        $user->update($data);

        return back()->with('success', __('Status atualizado.'));
    }
}
