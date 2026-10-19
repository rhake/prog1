@extends('layouts.app')
@section('title', __('Meus veículos').' — Autossencial')

@section('content')
    <div class="row">
        <h2>{{ __('Meus veículos') }}</h2>
        <a class="btn btn-sm" href="{{ route('app.vehicles.create') }}"><i data-lucide="plus"></i> {{ __('Adicionar') }}</a>
    </div>
    @forelse ($vehicles as $vehicle)
        <a class="card" href="{{ route('app.vehicles.show', $vehicle) }}" style="display:flex;gap:12px;align-items:center">
            <span class="bubble" style="margin:0"><i data-lucide="car"></i></span>
            <span style="flex:1">
                <strong>{{ $vehicle->label() }}</strong>
                <span class="small muted" style="display:block">{{ $vehicle->year }} · {{ $vehicle->plate }}</span>
            </span>
            <span class="small muted">@km($vehicle->mileage)</span>
            @if ($vehicle->activeSubscription?->plan)
                <span class="badge badge-primary">{{ $vehicle->activeSubscription->plan->plan_name }}</span>
            @endif
        </a>
    @empty
        <div class="empty">{{ __('Nenhum veículo cadastrado.') }}</div>
    @endforelse
@endsection
