@extends('layouts.admin')
@section('title', __('Notificações').' — Autossencial')

@section('content')
    <h2>{{ __('Notificações') }}</h2>
    <form class="card stack" method="post" action="{{ route('admin.alerts.store') }}">
        @csrf
        <h3>{{ __('Enviar notificação') }}</h3>
        <label class="field"><span>{{ __('Usuário') }}</span>
            <select name="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->email }}</option>
                @endforeach
            </select>
        </label>
        <label class="field"><span>{{ __('Tipo') }}</span>
            <select name="type">
                @foreach (['reminder' => __('Lembrete'), 'service_update' => __('Serviço'), 'payment' => __('Pagamento'), 'promotion' => __('Promoção'), 'alert' => __('Alerta')] as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </label>
        <label class="field"><span>{{ __('Mensagem') }}</span><textarea name="message" required></textarea></label>
        <button class="btn" type="submit">{{ __('Enviar') }}</button>
    </form>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>{{ __('Usuário') }}</th>
                    <th>{{ __('Tipo') }}</th>
                    <th>{{ __('Mensagem') }}</th>
                    <th>{{ __('Data') }}</th>
                    <th>{{ __('Lida') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alerts as $alert)
                    <tr>
                        <td>{{ $alert->user?->name }}</td>
                        <td><x-status :value="$alert->type" /></td>
                        <td>{{ $alert->message }}</td>
                        <td>{{ $alert->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $alert->read_status ? '✓' : '•' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
