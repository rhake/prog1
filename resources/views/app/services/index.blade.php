@extends('layouts.app')
@section('title', __('Serviços').' — Autossencial')

@section('content')
    <div class="row">
        <h2>{{ __('Meus serviços') }}</h2>
        <a class="btn btn-sm" href="{{ route('app.services.create') }}"><i data-lucide="plus"></i> {{ __('Solicitar') }}</a>
    </div>
    @forelse ($requests as $requestItem)
        <article class="card stack">
            <div class="row">
                <strong>{{ $requestItem->service_type }}</strong>
                <x-status :value="$requestItem->status" />
            </div>
            <p class="small muted">{{ $requestItem->description }}</p>
            <p class="small muted">{{ $requestItem->vehicle?->label() }} · {{ $requestItem->garage?->name }} · {{ optional($requestItem->scheduled_date)->format('d/m/Y') }}</p>
            @if (in_array($requestItem->status, ['pending', 'accepted'], true))
                <form method="post" action="{{ route('app.services.cancel', $requestItem) }}">
                    @csrf
                    @method('patch')
                    <button class="btn btn-sm btn-danger" type="submit">{{ __('Cancelar solicitação') }}</button>
                </form>
            @endif
        </article>
    @empty
        <div class="empty">{{ __('Nenhum serviço encontrado.') }}</div>
    @endforelse
@endsection
