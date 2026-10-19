@extends('layouts.admin')
@section('title', __('Usuários').' — Autossencial')

@section('content')
    <div class="row">
        <h2>{{ __('Usuários') }}</h2>
        <form class="search" method="get">
            <i data-lucide="search"></i>
            <input name="q" value="{{ $search }}" placeholder="{{ __('Buscar usuários') }}">
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>{{ __('Nome') }}</th>
                    <th>{{ __('E-mail') }}</th>
                    <th>{{ __('Telefone') }}</th>
                    <th>{{ __('Veículos') }}</th>
                    <th>{{ __('Plano') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    @php($plan = $user->subscriptions->first()?->plan)
                    <tr>
                        <td>{{ $user->name }}<div class="small muted">{{ $user->role === 'admin' ? __('Admin') : __('Cliente') }}</div></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?: '—' }}</td>
                        <td>{{ $user->vehicles_count }}</td>
                        <td>{{ $plan->plan_name ?? '—' }}</td>
                        <td>
                            <form method="post" action="{{ route('admin.users.update', $user) }}" class="actions">
                                @csrf
                                @method('patch')
                                <select name="status">
                                    @foreach (['active' => __('Ativo'), 'inactive' => __('Inativo'), 'suspended' => __('Suspenso')] as $value => $label)
                                        <option value="{{ $value }}" @selected($user->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm" type="submit">{{ __('Salvar') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">{{ __('Nenhum usuário encontrado.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
