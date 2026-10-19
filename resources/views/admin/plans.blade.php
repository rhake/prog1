@extends('layouts.admin')
@section('title', __('Planos').' — Autossencial')

@section('content')
    <h2>{{ __('Planos e assinaturas') }}</h2>
    <div class="plans">
        @foreach ($plans as $plan)
            <article class="card plan {{ $plan->isPopular() ? 'popular' : '' }}">
                <div class="row"><h3>{{ $plan->plan_name }}</h3><span class="badge badge-primary">{{ $plan->active_subscriptions_count }} {{ __('ativos') }}</span></div>
                <div class="price">@money($plan->monthly_price) <span>/{{ __('mês') }}</span></div>
                <ul>
                    @foreach ($plan->services_included as $item)
                        <li><i data-lucide="check"></i> {{ $item }}</li>
                    @endforeach
                </ul>
            </article>
        @endforeach
    </div>
    <h3>{{ __('Assinaturas') }}</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>{{ __('Usuário') }}</th>
                    <th>{{ __('Veículo') }}</th>
                    <th>{{ __('Plano') }}</th>
                    <th>{{ __('Data de início') }}</th>
                    <th>{{ __('Renovação') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->user?->name }}</td>
                        <td>{{ $subscription->vehicle?->label() }}</td>
                        <td>{{ $subscription->plan?->plan_name }}</td>
                        <td>{{ $subscription->start_date->format('d/m/Y') }}</td>
                        <td>{{ $subscription->renewal_date->format('d/m/Y') }}</td>
                        <td><x-status :value="$subscription->status" /></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
