@extends('layouts.app')
@section('title', __('Planos').' — Autossencial')

@section('content')
    <div>
        <h2>{{ __('Planos') }}</h2>
        <p class="muted">{{ __('Escolha a cobertura de cada veículo.') }}</p>
    </div>
    @foreach ($plans as $plan)
        <article class="card plan {{ $plan->isPopular() ? 'popular' : '' }}">
            @if ($plan->isPopular())
                <span class="popular-tag">Recomendado</span>
            @endif
            <h3>{{ $plan->plan_name }}</h3>
            <div class="price">@money($plan->monthly_price) <span>/{{ __('mês') }}</span></div>
            <p class="small muted">{{ $plan->description }}</p>
            <ul>
                @foreach ($plan->services_included as $item)
                    <li><i data-lucide="check"></i> {{ $item }}</li>
                @endforeach
            </ul>
            <p class="small muted center">{{ __('Até') }} {{ $plan->max_services_per_year }} {{ __('serviços/ano') }}</p>
            @if ($vehicles->isEmpty())
                <a class="btn btn-outline" href="{{ route('app.vehicles.create') }}">{{ __('Cadastre um veículo') }}</a>
                @if ($plan->isPopular())
                    <p class="plan-note">* Escolhe perfeita de 7 em cada 10 clientes</p>
                @endif
            @else
                <form class="stack" method="post" action="{{ route('app.plans.subscribe') }}">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <select name="vehicle_id" required>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->label() }} — {{ $vehicle->plate }}</option>
                        @endforeach
                    </select>
                    <button class="btn {{ $activePlanIds->contains($plan->id) ? 'btn-outline' : '' }}" type="submit">
                        {{ $activePlanIds->contains($plan->id) ? __('Trocar para este plano') : __('Escolher plano') }}
                    </button>
                    @if ($plan->isPopular())
                        <p class="plan-note">* Escolhe perfeita de 7 em cada 10 clientes</p>
                    @endif
                </form>
            @endif
        </article>
    @endforeach
@endsection
