@extends('layouts.app')
@section('title', __('Solicitar serviço').' — Autossencial')

@section('content')
    <a class="small muted" href="{{ route('app.services.index') }}"><i data-lucide="arrow-left"></i> {{ __('Voltar') }}</a>
    <h2>{{ __('Solicitar serviço') }}</h2>
    @if ($vehicles->isEmpty())
        <div class="empty">
            <p>{{ __('Cadastre um veículo antes de solicitar um serviço.') }}</p>
            <a class="btn btn-sm" style="margin-top:10px" href="{{ route('app.vehicles.create') }}">{{ __('Adicionar veículo') }}</a>
        </div>
    @else
        <form class="stack" method="post" action="{{ route('app.services.store') }}" data-wizard>
            @csrf
            <div class="steps" aria-hidden="true">
                <span class="step-dot on" data-step-dot></span>
                <span class="step-dot" data-step-dot></span>
                <span class="step-dot" data-step-dot></span>
                <span class="step-dot" data-step-dot></span>
            </div>
            <section class="stack" data-step>
                <p class="kicker">{{ __('Veículo') }}</p>
                @foreach ($vehicles as $vehicle)
                    <label class="choice">
                        <input type="radio" name="vehicle_id" value="{{ $vehicle->id }}" @checked(old('vehicle_id') == $vehicle->id)>
                        <span><strong>{{ $vehicle->label() }}</strong><span class="small muted" style="display:block">{{ $vehicle->plate }}</span></span>
                    </label>
                @endforeach
                <button class="btn" type="button" data-next>{{ __('Próximo') }}</button>
            </section>
            <section class="stack" data-step>
                <p class="kicker">{{ __('Serviço') }}</p>
                @foreach ($services as $service)
                    <label class="choice">
                        <input type="radio" name="service_id" value="{{ $service->id }}" @checked(old('service_id') == $service->id)>
                        <span style="flex:1"><strong>{{ $service->service_name }}</strong><span class="small muted" style="display:block">{{ $service->duration_minutes }} min</span></span>
                        <strong style="color:var(--orange)">@money($service->average_price)</strong>
                    </label>
                @endforeach
                <div class="row"><button class="btn btn-outline" type="button" data-prev>{{ __('Voltar') }}</button><button class="btn" type="button" data-next>{{ __('Próximo') }}</button></div>
            </section>
            <section class="stack" data-step>
                <p class="kicker">{{ __('Oficina') }}</p>
                @foreach ($garages as $garage)
                    <label class="choice">
                        <input type="radio" name="garage_id" value="{{ $garage->id }}" @checked(old('garage_id') == $garage->id)>
                        <span style="flex:1"><strong>{{ $garage->name }}</strong><span class="small muted" style="display:block">{{ $garage->address }}</span></span>
                        <span>★ {{ number_format($garage->rating, 1, ',', '.') }}</span>
                    </label>
                @endforeach
                <div class="row"><button class="btn btn-outline" type="button" data-prev>{{ __('Voltar') }}</button><button class="btn" type="button" data-next>{{ __('Próximo') }}</button></div>
            </section>
            <section class="stack" data-step>
                <p class="kicker">{{ __('Confirmar') }}</p>
                <label class="field"><span>{{ __('Data') }}</span><input type="date" name="scheduled_date" value="{{ old('scheduled_date', now()->addDay()->toDateString()) }}" required></label>
                <label class="field"><span>{{ __('Descrição') }}</span><textarea name="description">{{ old('description') }}</textarea></label>
                <div class="row"><button class="btn btn-outline" type="button" data-prev>{{ __('Voltar') }}</button><button class="btn" type="submit">{{ __('Confirmar agendamento') }}</button></div>
            </section>
        </form>
    @endif
@endsection
