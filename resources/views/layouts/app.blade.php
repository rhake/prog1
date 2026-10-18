@extends('layouts.base')

@section('body')
    @php
        $tabs = [
            ['route' => 'app.home', 'match' => 'app.home', 'icon' => 'house', 'label' => __('Início')],
            ['route' => 'app.services.index', 'match' => 'app.services.*', 'icon' => 'wrench', 'label' => __('Serviços')],
            ['route' => 'app.map', 'match' => 'app.map', 'icon' => 'map-pin', 'label' => __('Mapa')],
            ['route' => 'app.profile', 'match' => 'app.profile', 'icon' => 'user', 'label' => __('Perfil')],
        ];
    @endphp
    <div class="app-shell">
        <header class="app-header">
            <a href="{{ route('app.home') }}" class="brand">
                <img src="{{ asset('images/mark.png') }}" class="mark logo-dark" alt="">
                <img src="{{ asset('images/mark-light.png') }}" class="mark logo-light" alt="">
                Autossencial
            </a>
            <div class="header-actions">
                <a class="icon-btn" href="{{ route('theme') }}" aria-label="{{ __('Tema') }}"><i data-lucide="sun-moon"></i></a>
                <a class="icon-btn" href="{{ route('app.alerts') }}" aria-label="{{ __('Notificações') }}">
                    <i data-lucide="bell"></i>
                    @if (($unreadCount ?? 0) > 0)
                        <span class="dot-count">{{ $unreadCount }}</span>
                    @endif
                </a>
            </div>
        </header>
        <main class="app-main stack">
            @include('partials.flashes')
            @yield('content')
        </main>
        <nav class="tabbar">
            <div class="tabbar-inner">
                @foreach ($tabs as $tab)
                    <a class="tab {{ request()->routeIs($tab['match']) ? 'on' : '' }}" href="{{ route($tab['route']) }}">
                        <i data-lucide="{{ $tab['icon'] }}"></i>
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>
    </div>
@endsection
