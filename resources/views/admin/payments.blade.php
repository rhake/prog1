@extends('layouts.admin')
@section('title', __('Financeiro').' — Autossencial')

@section('content')
    <h2>{{ __('Financeiro') }}</h2>
    <div class="kpis">
        <article class="card kpi"><span class="small muted">{{ __('Recebido') }}</span><strong>@money($paid)</strong></article>
        <article class="card kpi"><span class="small muted">{{ __('Pendente') }}</span><strong>@money($pending)</strong></article>
        <article class="card kpi"><span class="small muted">{{ __('Transações') }}</span><strong>{{ $payments->count() }}</strong></article>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>{{ __('Usuário') }}</th>
                    <th>{{ __('Plano') }}</th>
                    <th>{{ __('Valor') }}</th>
                    <th>{{ __('Método') }}</th>
                    <th>{{ __('Data') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->user?->name }}</td>
                        <td>{{ $payment->subscription?->plan?->plan_name }}</td>
                        <td>@money($payment->amount)</td>
                        <td><x-status :value="$payment->payment_method" /></td>
                        <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                        <td><x-status :value="$payment->payment_status" /></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
