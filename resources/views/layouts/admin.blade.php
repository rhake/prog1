@extends('layouts.base')

@section('body')
    @php
        $links = [
            ['admin.dashboard', 'layout-dashboard', __('Painel')],
            ['admin.users', 'users', __('Usuários')],
            ['admin.vehicles', 'car', __('Veículos')],
            ['admin.services', 'wrench', __('Serviços')],
            ['admin.garages', 'warehouse', __('Oficinas')],
            ['admin.plans', 'clipboard-list', __('Planos')],
            ['admin.payments', 'credit-card', __('Financeiro')],
            ['admin.alerts', 'bell', __('Notificações')],
        ];
    @endphp
    <div class="admin">
        <aside class="sidebar">
            <x-brand :href="route('admin.dashboard')" class="brand" style="padding:8px 10px 16px" />
            <nav class="side-nav">
                @foreach ($links as [$route, $icon, $label])
                    <a class="side-link {{ request()->routeIs($route) ? 'on' : '' }}" href="{{ route($route) }}">
                        <i data-lucide="{{ $icon }}"></i>
                        <span class="label">{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button class="side-link btn-danger" style="width:100%" type="submit">
                    <i data-lucide="log-out"></i>
                    <span class="label">{{ __('Sair') }}</span>
                </button>
            </form>
        </aside>
        <div class="admin-main">
            <header class="admin-top">
                <strong>{{ __('Painel administrativo') }}</strong>
                <div class="header-actions">
                    <a class="icon-btn" href="{{ route('theme') }}" aria-label="{{ __('Tema') }}"><i data-lucide="sun-moon"></i></a>
                    <span class="small muted">{{ auth()->user()->name }}</span>
                </div>
            </header>
            <div class="admin-content">
                @include('partials.flashes')
                @yield('content')
            </div>
        </div>
    </div>
@endsection
