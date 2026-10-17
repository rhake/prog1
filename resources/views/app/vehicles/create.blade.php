@extends('layouts.app')
@section('title', __('Adicionar veículo').' — Autossencial')

@section('content')
    <a class="small muted" href="{{ route('app.vehicles.index') }}"><i data-lucide="arrow-left"></i> {{ __('Voltar') }}</a>
    <h2>{{ __('Adicionar veículo') }}</h2>
    <form class="card stack" method="post" action="{{ route('app.vehicles.store') }}">
        @csrf
        <label class="field"><span>{{ __('Marca') }}</span><input name="brand" value="{{ old('brand') }}" required></label>
        <label class="field"><span>{{ __('Modelo') }}</span><input name="model" value="{{ old('model') }}" required></label>
        <label class="field"><span>{{ __('Ano') }}</span><input type="number" name="year" value="{{ old('year', now()->year) }}" required></label>
        <label class="field"><span>{{ __('Placa') }}</span><input name="plate" value="{{ old('plate') }}" required placeholder="ABC1D23"></label>
        <label class="field"><span>{{ __('Cor') }}</span><input name="color" value="{{ old('color') }}"></label>
        <label class="field"><span>{{ __('Chassi') }}</span><input name="vin" value="{{ old('vin') }}"></label>
        <label class="field"><span>{{ __('Quilometragem') }}</span><input type="number" name="mileage" value="{{ old('mileage', 0) }}" min="0" required></label>
        <button class="btn" type="submit">{{ __('Salvar') }}</button>
    </form>
@endsection
