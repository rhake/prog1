@extends('layouts.admin')
@section('title', __('Painel').' — Autossencial')

@section('content')
    <h2>{{ __('Painel') }}</h2>
    <div class="kpis">
        <article class="card kpi"><span class="small muted">{{ __('Usuários') }}</span><strong>{{ $users }}</strong></article>
        <article class="card kpi"><span class="small muted">{{ __('Veículos') }}</span><strong>{{ $vehicles }}</strong></article>
        <article class="card kpi"><span class="small muted">{{ __('Serviços pendentes') }}</span><strong>{{ $pending }}</strong></article>
        <article class="card kpi"><span class="small muted">{{ __('Receita recebida') }}</span><strong>@money($revenue)</strong></article>
    </div>
    <div class="split">
        <article class="card stack">
            <h3>{{ __('Rastreamento') }}</h3>
            @php
                $points = $devices->map(fn ($device) => [
                    'lat' => $device->latitude,
                    'lng' => $device->longitude,
                    'name' => $device->name,
                    'address' => $device->address,
                ])->values();
            @endphp
            <div id="map" class="map-canvas" data-points="{{ json_encode($points) }}"></div>
            <p class="small muted">
                {{ __('Online') }} {{ $devices->where('status', 'online')->count() }} ·
                {{ __('Offline') }} {{ $devices->where('status', 'offline')->count() }}
            </p>
        </article>
        <article class="card stack">
            <h3>{{ __('Serviços recentes') }}</h3>
            @foreach ($recent as $item)
                <a class="row" href="{{ route('admin.services.show', $item) }}">
                    <span>
                        <strong>{{ $item->service_type }}</strong>
                        <span class="small muted" style="display:block">{{ $item->user?->name }} · {{ optional($item->scheduled_date)->format('d/m/Y') }}</span>
                    </span>
                    <x-status :value="$item->status" />
                </a>
            @endforeach
        </article>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}">
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
@endpush
