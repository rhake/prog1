@extends('layouts.app')
@section('title', __('Perfil').' — Autossencial')

@section('content')
    <div class="center">
        <div class="avatar"><i data-lucide="user"></i></div>
        <h2>{{ $user->name }}</h2>
        <p class="small muted">{{ __('Cliente desde') }} {{ $user->created_at->translatedFormat('F Y') }}</p>
    </div>
    <div class="stats">
        <a class="stat" href="{{ route('app.vehicles.index') }}"><i data-lucide="car"></i><strong>{{ $vehicleCount }}</strong><span class="small muted">{{ __('Veículos') }}</span></a>
        <a class="stat" href="{{ route('app.plans') }}"><strong>{{ $subscriptionCount }}</strong><span class="small muted">{{ __('Assinaturas') }}</span></a>
    </div>
    <form class="card stack" method="post" action="{{ route('app.profile.update') }}">
        @csrf
        @method('put')
        <h3>{{ __('Informações pessoais') }}</h3>
        <label class="field"><span>{{ __('Nome') }}</span><input name="name" value="{{ old('name', $user->name) }}" required></label>
        <label class="field"><span>{{ __('E-mail') }}</span><input type="email" name="email" value="{{ old('email', $user->email) }}" required></label>
        <label class="field"><span>{{ __('Telefone') }}</span><input name="phone" value="{{ old('phone', $user->phone) }}"></label>
        <label class="field"><span>{{ __('Endereço') }}</span><input name="address" value="{{ old('address', $user->address) }}"></label>
        <h3>{{ __('Alterar senha') }}</h3>
        <label class="field"><span>{{ __('Senha atual') }}</span><input type="password" name="current_password"></label>
        <label class="field"><span>{{ __('Nova senha') }}</span><input type="password" name="password"></label>
        <label class="field"><span>{{ __('Confirmar senha') }}</span><input type="password" name="password_confirmation"></label>
        <button class="btn" type="submit">{{ __('Salvar') }}</button>
    </form>
    <a class="menu-link" href="{{ route('app.vehicles.index') }}">{{ __('Meus veículos') }} <i data-lucide="chevron-right"></i></a>
    <a class="menu-link" href="{{ route('app.plans') }}">{{ __('Planos') }} <i data-lucide="chevron-right"></i></a>
    <a class="menu-link" href="{{ route('theme') }}">{{ request()->cookie('theme', 'dark') === 'light' ? __('Usar tema escuro') : __('Usar tema claro') }} <i data-lucide="sun-moon"></i></a>
    <form method="post" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-outline btn-block btn-danger" type="submit"><i data-lucide="log-out"></i> {{ __('Sair') }}</button>
    </form>
@endsection
