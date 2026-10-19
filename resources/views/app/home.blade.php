@extends('layouts.app')
@section('title', __('Início').' — Autossencial')

@section('content')
    <div>
        <p class="muted">{{ __('Olá,') }}</p>
        <h2 style="font-size:1.8rem">{{ $user->firstName() }}</h2>
    </div>

    @if ($unread->isNotEmpty())
        <a class="banner" href="{{ route('app.alerts') }}">
            <i data-lucide="bell"></i>
            <span>
                <strong>{{ $unread->count() }} {{ __('notificação(ões) não lida(s)') }}</strong>
                <span class="small muted" style="display:block">{{ $unread->first()->message }}</span>
            </span>
        </a>
    @endif

    @if ($primary)
        <div>
            <div class="row" style="margin-bottom:8px">
                <span class="kicker">{{ __('Veículo principal') }}</span>
                <a class="small" style="color:var(--orange)" href="{{ route('app.vehicles.index') }}">{{ __('Ver todos') }}</a>
            </div>
            <a class="vehicle-hero" href="{{ route('app.vehicles.show', $primary) }}" style="display:flex;gap:14px;align-items:center">
                <span class="bubble" style="margin:0"><i data-lucide="car"></i></span>
                <span>
                    <strong style="font-size:1.15rem">{{ $primary->label() }}</strong>
                    <span class="small muted" style="display:block">{{ $primary->year }} · {{ $primary->plate }}</span>
                    <span class="small muted">@km($primary->mileage) · {{ $primary->color }}</span>
                </span>
            </a>
        </div>
    @else
        <div class="empty">
            <p>{{ __('Nenhum veículo cadastrado.') }}</p>
            <a class="btn btn-sm" style="margin-top:10px" href="{{ route('app.vehicles.create') }}">{{ __('Adicionar veículo') }}</a>
        </div>
    @endif

    @if ($subscription?->plan)
        <article class="card" style="border-top:3px solid var(--orange)">
            <div class="row">
                <div>
                    <strong>{{ __('Plano') }} {{ $subscription->plan->plan_name }}</strong>
                    <p class="small muted">@money($subscription->plan->monthly_price)/{{ __('mês') }}</p>
                </div>
                <a class="btn btn-sm btn-outline" href="{{ route('app.plans') }}">{{ __('Alterar') }}</a>
            </div>
        </article>
    @endif

    @if ($activeService)
        <div>
            <span class="kicker">{{ __('Serviço ativo') }}</span>
            <a class="card" style="display:flex;justify-content:space-between;gap:10px;margin-top:8px" href="{{ route('app.services.index') }}">
                <span>
                    <strong>{{ $activeService->service_type }}</strong>
                    <span class="small muted" style="display:block">{{ optional($activeService->scheduled_date)->format('d/m/Y') }}</span>
                </span>
                <x-status :value="$activeService->status" />
            </a>
        </div>
    @endif

    <div>
        <span class="kicker">{{ __('Ações rápidas') }}</span>
        <div class="quick" style="margin-top:8px">
            <a href="{{ route('app.services.create') }}"><span class="bubble" style="margin:0 auto 8px"><i data-lucide="wrench"></i></span>{{ __('Solicitar serviço') }}</a>
            <a href="{{ route('app.map') }}"><span class="bubble" style="margin:0 auto 8px"><i data-lucide="map-pin"></i></span>{{ __('Localizar') }}</a>
            <a href="{{ route('app.vehicles.index') }}"><span class="bubble" style="margin:0 auto 8px"><i data-lucide="car"></i></span>{{ __('Meus veículos') }}</a>
        </div>
    </div>
@endsection
