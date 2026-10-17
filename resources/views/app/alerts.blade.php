@extends('layouts.app')
@section('title', __('Notificações').' — Autossencial')

@section('content')
    <div class="row">
        <h2>{{ __('Notificações') }}</h2>
        @if ($alerts->contains(fn ($alert) => ! $alert->read_status))
            <form method="post" action="{{ route('app.alerts.read-all') }}">
                @csrf
                <button class="btn btn-sm btn-outline" type="submit">{{ __('Marcar todas como lidas') }}</button>
            </form>
        @endif
    </div>
    @forelse ($alerts as $alert)
        <article class="card row" style="{{ $alert->read_status ? '' : 'border-color:var(--orange)' }}">
            <span>
                <x-status :value="$alert->type" />
                <p style="margin-top:6px">{{ $alert->message }}</p>
                <span class="small muted">{{ $alert->created_at->timezone(config('app.timezone'))->translatedFormat('d M Y H:i') }}</span>
            </span>
            @unless ($alert->read_status)
                <form method="post" action="{{ route('app.alerts.read', $alert) }}">
                    @csrf
                    @method('patch')
                    <button class="btn btn-sm btn-ghost" type="submit">{{ __('Lida') }}</button>
                </form>
            @endunless
        </article>
    @empty
        <div class="empty">{{ __('Nenhuma notificação.') }}</div>
    @endforelse
@endsection
