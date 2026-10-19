@extends('layouts.admin')
@section('title', $item->service_type.' — Autossencial')

@section('content')
    <a class="small muted" href="{{ route('admin.services') }}"><i data-lucide="arrow-left"></i> {{ __('Voltar') }}</a>

    <div class="row">
        <div>
            <span class="kicker">{{ __('Serviço') }} #{{ $item->id }}</span>
            <h2>{{ $item->service_type }}</h2>
            <p class="muted">{{ $item->user?->name }} · {{ $item->vehicle?->label() }} · {{ $item->garage?->name }}</p>
        </div>
        <x-status :value="$item->status" />
    </div>

    <article class="card stack">
        <p>{{ $item->description }}</p>
        <p class="small muted">{{ __('Agendado para') }} {{ optional($item->scheduled_date)->format('d/m/Y') }}</p>
        <div class="actions">
            @foreach (['pending' => ['accepted' => __('Aceitar'), 'denied' => __('Recusar')], 'accepted' => ['in_progress' => __('Iniciar'), 'cancelled' => __('Cancelar')], 'in_progress' => ['completed' => __('Concluir')]][$item->status] ?? [] as $status => $label)
                <form method="post" action="{{ route('admin.services.update', $item) }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="status" value="{{ $status }}">
                    <button class="btn btn-sm {{ $status === 'denied' || $status === 'cancelled' ? 'btn-outline' : '' }}" type="submit">{{ $label }}</button>
                </form>
            @endforeach
        </div>
    </article>

    <div class="split">
        <form class="card stack" method="post" action="{{ route('admin.services.visit', $item) }}">
            @csrf
            @method('patch')
            <span class="kicker">{{ __('Horários e anotações') }}</span>
            <label class="field">
                <span>{{ __('Entrada do veículo') }}</span>
                <input type="datetime-local" name="arrived_at" value="{{ optional($item->arrived_at)->format('Y-m-d\TH:i') }}">
            </label>
            <label class="field">
                <span>{{ __('Saída do veículo') }}</span>
                <input type="datetime-local" name="departed_at" value="{{ optional($item->departed_at)->format('Y-m-d\TH:i') }}">
            </label>
            <label class="field">
                <span>{{ __('Anotações') }}</span>
                <textarea name="provider_notes" rows="5" placeholder="{{ __('Observações do prestador, autorizações e apontamentos.') }}">{{ old('provider_notes', $item->provider_notes) }}</textarea>
            </label>
            <button class="btn btn-sm" type="submit">{{ __('Salvar anotações') }}</button>
        </form>

        <form class="card stack" method="post" action="{{ route('admin.services.invoice', $item) }}" enctype="multipart/form-data">
            @csrf
            <span class="kicker">{{ __('Nota fiscal') }}</span>
            @if ($item->invoiceUrl())
                <a class="invoice-link" href="{{ $item->invoiceUrl() }}" target="_blank" rel="noopener">
                    <i data-lucide="file-text"></i>
                    <span>{{ $item->invoice_name ?: __('Ver nota fiscal') }}</span>
                </a>
            @else
                <p class="muted">{{ __('Nenhuma nota anexada.') }}</p>
            @endif
            <label class="field">
                <span>{{ __('Anexar NFS-e / DANFE') }}</span>
                <input type="file" name="invoice" accept=".pdf,image/*,.svg" required>
            </label>
            <button class="btn btn-sm btn-outline" type="submit">{{ __('Enviar nota') }}</button>
        </form>
    </div>

    <article class="card stack">
        <span class="kicker">{{ __('Fotos') }}</span>
        <form class="photo-upload" method="post" action="{{ route('admin.services.photos.store', $item) }}" enctype="multipart/form-data">
            @csrf
            <label class="field">
                <span>{{ __('Tipo') }}</span>
                <select name="kind">
                    <option value="service">{{ __('Foto do serviço') }}</option>
                    <option value="entry">{{ __('Foto de entrada') }}</option>
                    <option value="exit">{{ __('Foto de saída') }}</option>
                </select>
            </label>
            <label class="field">
                <span>{{ __('Legenda') }}</span>
                <input type="text" name="caption" maxlength="180" placeholder="{{ __('Ex.: risco no para-choque') }}">
            </label>
            <label class="field">
                <span>{{ __('Arquivos') }}</span>
                <input type="file" name="photos[]" accept="image/*,.svg" multiple required>
            </label>
            <button class="btn btn-sm" type="submit">{{ __('Anexar fotos') }}</button>
        </form>

        <div>
            <strong>{{ __('Fotos do serviço') }}</strong>
            @include('partials.service-photos', ['item' => $item, 'kind' => 'service', 'empty' => __('Nenhuma foto do serviço.'), 'manage' => true])
        </div>
        <div>
            <strong>{{ __('Fotos de entrada') }}</strong>
            <p class="small muted">{{ __('Opcional') }}</p>
            @include('partials.service-photos', ['item' => $item, 'kind' => 'entry', 'empty' => __('Sem fotos de entrada.'), 'manage' => true])
        </div>
        <div>
            <strong>{{ __('Fotos de saída') }}</strong>
            <p class="small muted">{{ __('Opcional') }}</p>
            @include('partials.service-photos', ['item' => $item, 'kind' => 'exit', 'empty' => __('Sem fotos de saída.'), 'manage' => true])
        </div>
    </article>

    <form class="card stack" method="post" action="{{ route('admin.services.checklist', $item) }}">
        @csrf
        @method('patch')
        <span class="kicker">{{ __('Check-list de itens') }}</span>
        <p class="small muted">{{ __('Padrão de reboque e socorro: conferir itens do carro e apontar danos na lataria.') }}</p>
        @php($groups = $item->checklistItems->groupBy('area'))
        @foreach ($groups as $area => $rows)
            <div class="checklist-area">
                <strong>{{ $area }}</strong>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>{{ __('Item') }}</th>
                                <th>{{ __('Situação') }}</th>
                                <th>{{ __('Apontamento') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <td>{{ $row->label }}</td>
                                    <td>
                                        <select name="items[{{ $row->id }}][status]">
                                            @foreach (\App\Models\ServiceChecklistItem::STATUSES as $status)
                                                <option value="{{ $status }}" @selected($row->status === $status)>{{ \App\Support\Labels::status($status)[0] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $row->id }}][notes]" value="{{ $row->notes }}" maxlength="255" placeholder="{{ __('Opcional') }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        <button class="btn" type="submit">{{ __('Salvar check-list') }}</button>
    </form>
@endsection
