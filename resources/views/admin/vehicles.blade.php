@extends('layouts.admin')
@section('title', __('Veículos').' — Autossencial')

@section('content')
    <div class="row">
        <h2>{{ __('Veículos') }}</h2>
        <form class="search" method="get">
            <i data-lucide="search"></i>
            <input name="q" value="{{ $search }}" placeholder="{{ __('Buscar veículos') }}">
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>{{ __('Veículo') }}</th>
                    <th>{{ __('Placa') }}</th>
                    <th>{{ __('Proprietário') }}</th>
                    <th>{{ __('Ano') }}</th>
                    <th>{{ __('Km') }}</th>
                    <th>{{ __('Cor') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->label() }}</td>
                        <td>{{ $vehicle->plate }}</td>
                        <td>{{ $vehicle->user?->name }}</td>
                        <td>{{ $vehicle->year }}</td>
                        <td>{{ number_format($vehicle->mileage, 0, ',', '.') }}</td>
                        <td>{{ $vehicle->color }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">{{ __('Nenhum veículo encontrado.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
