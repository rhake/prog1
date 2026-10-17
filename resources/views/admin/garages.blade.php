@extends('layouts.admin')
@section('title', __('Oficinas').' — Autossencial')

@section('content')
    <h2>{{ __('Oficinas parceiras') }}</h2>
    @php
        $points = $garages->map(fn ($garage) => [
            'lat' => $garage->latitude,
            'lng' => $garage->longitude,
            'name' => $garage->name,
            'address' => $garage->address.', '.$garage->city,
        ])->values();
    @endphp
    <div id="map" class="map-canvas" data-points="{{ json_encode($points) }}"></div>
    <div class="features">
        @foreach ($garages as $garage)
            <article class="card">
                <div class="row">
                    <strong>{{ $garage->name }}</strong>
                    <span style="color:var(--orange)">★ {{ number_format($garage->rating, 1, ',', '.') }}</span>
                </div>
                <p class="small muted">{{ $garage->address }}, {{ $garage->city }}</p>
                <p class="small muted">{{ $garage->phone }}</p>
                <form method="post" action="{{ route('admin.garages.destroy', $garage) }}" style="margin-top:10px">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger" type="submit">{{ __('Remover') }}</button>
                </form>
            </article>
        @endforeach
    </div>
    <form class="card stack" method="post" action="{{ route('admin.garages.store') }}">
        @csrf
        <h3>{{ __('Nova oficina') }}</h3>
        <div class="stats">
            <label class="field"><span>{{ __('Nome') }}</span><input name="name" required></label>
            <label class="field"><span>{{ __('Cidade') }}</span><input name="city" required></label>
            <label class="field"><span>{{ __('Endereço') }}</span><input name="address" required></label>
            <label class="field"><span>{{ __('Telefone') }}</span><input name="phone" required></label>
            <label class="field"><span>{{ __('Latitude') }}</span><input name="latitude" value="-23.55" required></label>
            <label class="field"><span>{{ __('Longitude') }}</span><input name="longitude" value="-46.63" required></label>
            <label class="field"><span>{{ __('Nota') }}</span><input name="rating" value="5" step="0.1" min="0" max="5" required></label>
        </div>
        <button class="btn" type="submit">{{ __('Cadastrar oficina') }}</button>
    </form>
@endsection

@push('head')
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}">
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
@endpush
