@extends('layouts.app')
@section('title', $item->service_type.' — Autossencial')

@section('content')
    <a class="small muted" href="{{ route('app.services.index') }}"><i data-lucide="arrow-left"></i> {{ __('Voltar') }}</a>

    <article class="card stack">
        <div class="row">
            <div>
                <span class="kicker">{{ __('Serviço') }}</span>
                <h2>{{ $item->service_type }}</h2>
            </div>
            <x-status :value="$item->status" />
        </div>
        <p>{{ $item->description }}</p>
        <p class="small muted">{{ $item->vehicle?->label() }} · {{ $item->garage?->name }} · {{ optional($item->scheduled_date)->format('d/m/Y') }}</p>
        @if (in_array($item->status, ['pending', 'accepted'], true))
            <form method="post" action="{{ route('app.services.cancel', $item) }}">
                @csrf
                @method('patch')
                <button class="btn btn-sm btn-danger" type="submit">{{ __('Cancelar solicitação') }}</button>
            </form>
        @endif
    </article>

    <div class="stats">
        <div class="stat">
            <span class="small muted">{{ __('Entrada do veículo') }}</span>
            <strong style="font-size:1rem">{{ $item->arrived_at?->format('d/m/Y H:i') ?? '—' }}</strong>
        </div>
        <div class="stat">
            <span class="small muted">{{ __('Saída do veículo') }}</span>
            <strong style="font-size:1rem">{{ $item->departed_at?->format('d/m/Y H:i') ?? '—' }}</strong>
        </div>
    </div>

    <article class="card stack">
        <span class="kicker">{{ __('Anotações do prestador') }}</span>
        @if ($item->provider_notes)
            <p>{{ $item->provider_notes }}</p>
        @else
            <p class="muted">{{ __('Nenhuma anotação ainda.') }}</p>
        @endif
    </article>

    <article class="card stack">
        <span class="kicker">{{ __('Nota fiscal') }}</span>
        @if ($item->invoiceUrl())
            <a class="invoice-link" href="{{ $item->invoiceUrl() }}" target="_blank" rel="noopener">
                <i data-lucide="file-text"></i>
                <span>{{ $item->invoice_name ?: __('Ver nota fiscal') }}</span>
            </a>
        @else
            <p class="muted">{{ __('O prestador ainda não anexou a nota fiscal.') }}</p>
        @endif
    </article>

    <article class="card stack">
        <span class="kicker">{{ __('Fotos do serviço') }}</span>
        @include('partials.service-photos', ['item' => $item, 'kind' => 'service', 'empty' => __('Nenhuma foto do serviço ainda.')])
    </article>

    <article class="card stack">
        <span class="kicker">{{ __('Fotos de entrada') }}</span>
        <p class="small muted">{{ __('Opcional — registro do veículo ao chegar.') }}</p>
        @include('partials.service-photos', ['item' => $item, 'kind' => 'entry', 'empty' => __('Sem fotos de entrada.')])
    </article>

    <article class="card stack">
        <span class="kicker">{{ __('Fotos de saída') }}</span>
        <p class="small muted">{{ __('Opcional — registro do veículo ao sair.') }}</p>
        @include('partials.service-photos', ['item' => $item, 'kind' => 'exit', 'empty' => __('Sem fotos de saída.')])
    </article>

    <article class="card stack">
        <span class="kicker">{{ __('Check-list de itens') }}</span>
        <p class="small muted">{{ __('Padrão de reboque e socorro: documentos, lataria, vidros, pneus e interior.') }}</p>
        @php($groups = $item->checklistItems->groupBy('area'))
        @foreach ($groups as $area => $rows)
            <div class="checklist-area">
                <strong>{{ $area }}</strong>
                <ul class="checklist">
                    @foreach ($rows as $row)
                        <li>
                            <span>{{ $row->label }}</span>
                            <x-status :value="$row->status" />
                            @if ($row->notes)
                                <em>{{ $row->notes }}</em>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </article>
@endsection
