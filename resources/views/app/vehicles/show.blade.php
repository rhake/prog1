@extends('layouts.app')
@section('title', $vehicle->label().' — Autossencial')

@section('content')
    <a class="small muted" href="{{ route('app.vehicles.index') }}"><i data-lucide="arrow-left"></i> {{ __('Voltar') }}</a>
    <article class="card" style="display:flex;gap:14px;align-items:center">
        <span class="bubble" style="width:58px;height:58px;margin:0"><i data-lucide="car"></i></span>
        <div>
            <h2>{{ $vehicle->label() }}</h2>
            <p class="muted">{{ $vehicle->year }} · {{ $vehicle->color }}</p>
            <strong>{{ $vehicle->plate }}</strong>
        </div>
    </article>
    <div class="stats">
        <div class="stat"><span class="small muted">{{ __('Quilometragem') }}</span><strong style="font-size:1rem">@km($vehicle->mileage)</strong></div>
        <div class="stat"><span class="small muted">{{ __('Plano') }}</span><strong style="font-size:1rem">{{ $subscription?->plan->plan_name ?? __('Nenhum') }}</strong></div>
    </div>
    <form class="card row" method="post" action="{{ route('app.vehicles.update', $vehicle) }}">
        @csrf
        @method('patch')
        <label class="field" style="flex:1"><span>{{ __('Atualizar km') }}</span><input type="number" name="mileage" value="{{ $vehicle->mileage }}" min="0"></label>
        <button class="btn btn-sm" type="submit">{{ __('Salvar') }}</button>
    </form>
    @if ($vehicle->device)
        @php
            $points = [[
                'lat' => $vehicle->device->latitude,
                'lng' => $vehicle->device->longitude,
                'name' => $vehicle->device->name,
                'address' => $vehicle->device->address,
            ]];
        @endphp
        <div id="map" class="map-canvas" data-points="{{ json_encode($points) }}"></div>
    @endif
    <div class="quick">
        <a href="{{ route('app.services.create') }}"><i data-lucide="wrench"></i><br>{{ __('Solicitar serviço') }}</a>
        <a href="{{ route('app.map') }}"><i data-lucide="map-pin"></i><br>{{ __('Localizar') }}</a>
    </div>
    <div>
        <span class="kicker">{{ __('Histórico de serviços') }}</span>
        <div class="stack" style="margin-top:8px">
            @forelse ($vehicle->histories as $history)
                <article class="card">
                    <div class="row">
                        <strong>{{ $history->service?->service_name ?? __('Serviço') }}</strong>
                        <span style="color:var(--orange)">@money($history->cost)</span>
                    </div>
                    <p class="small muted">{{ $history->garage->name ?? '' }} · {{ $history->service_date->format('d/m/Y') }}</p>
                    @if ($history->notes)
                        <p class="small" style="margin-top:6px">“{{ $history->notes }}”</p>
                    @endif
                </article>
            @empty
                <p class="muted">{{ __('Nenhum serviço registrado.') }}</p>
            @endforelse
        </div>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}">
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
@endpush
