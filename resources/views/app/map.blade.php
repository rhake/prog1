@extends('layouts.app')
@section('title', __('Mapa').' — Autossencial')

@section('content')
    <h2>{{ __('Localização') }}</h2>
    <p class="small muted">{{ __('Rastreadores vinculados aos seus veículos.') }}</p>
    @php
        $points = $devices->map(fn ($device) => [
            'lat' => $device->latitude,
            'lng' => $device->longitude,
            'name' => $device->name,
            'address' => $device->address,
            'status' => $device->status,
        ])->values();
    @endphp
    <div id="map" class="map-canvas" data-points="{{ json_encode($points) }}"></div>
    @forelse ($devices as $device)
        <article class="card row">
            <span>
                <strong>{{ $device->name }}</strong>
                <span class="small muted" style="display:block">{{ $device->address }}</span>
                <span class="small muted">{{ optional($device->last_update)->diffForHumans() }} · {{ number_format($device->speed, 0) }} km/h</span>
            </span>
            <x-status :value="$device->status" />
        </article>
    @empty
        <div class="empty">{{ __('Nenhum rastreador vinculado.') }}</div>
    @endforelse
@endsection

@push('head')
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}">
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
@endpush
