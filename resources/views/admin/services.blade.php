@extends('layouts.admin')
@section('title', __('Serviços').' — Autossencial')

@section('content')
    <h2>{{ __('Gestão de serviços') }}</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>{{ __('Serviço') }}</th>
                    <th>{{ __('Cliente') }}</th>
                    <th>{{ __('Veículo') }}</th>
                    <th>{{ __('Oficina') }}</th>
                    <th>{{ __('Data') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Ações') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $item)
                    <tr>
                        <td>{{ $item->service_type }}</td>
                        <td>{{ $item->user?->name }}</td>
                        <td>{{ $item->vehicle?->label() }}</td>
                        <td>{{ $item->garage?->name }}</td>
                        <td>{{ optional($item->scheduled_date)->format('d/m/Y') }}</td>
                        <td><x-status :value="$item->status" /></td>
                        <td class="actions">
                            @foreach (['pending' => ['accepted' => __('Aceitar'), 'denied' => __('Recusar')], 'accepted' => ['in_progress' => __('Iniciar'), 'cancelled' => __('Cancelar')], 'in_progress' => ['completed' => __('Concluir')]][$item->status] ?? [] as $status => $label)
                                <form method="post" action="{{ route('admin.services.update', $item) }}">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button class="btn btn-sm {{ $status === 'denied' || $status === 'cancelled' ? 'btn-outline' : '' }}" type="submit">{{ $label }}</button>
                                </form>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
