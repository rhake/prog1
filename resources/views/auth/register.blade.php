@extends('layouts.base')
@section('title', __('Criar conta').' — Autossencial')

@section('body')
    <main class="auth">
        <div class="auth-card">
            <a href="{{ route('home') }}" class="small muted" style="display:inline-flex;gap:6px;align-items:center"><i data-lucide="arrow-left"></i> {{ __('Voltar') }}</a>
            <img src="{{ asset('images/logo.png') }}" class="auth-logo logo-dark" alt="Autossencial">
            <img src="{{ asset('images/logo-light.png') }}" class="auth-logo logo-light" alt="Autossencial">
            <div class="center">
                <h1 style="font-size:1.6rem">{{ __('Criar conta') }}</h1>
                <p class="muted">{{ __('Comece seu plano de saúde veicular.') }}</p>
            </div>
            <form class="card stack" method="post" action="{{ route('register') }}">
                @csrf
                @include('partials.flashes')
                <label class="field"><span>{{ __('Nome completo') }}</span>
                    <input name="name" value="{{ old('name') }}" required autofocus>
                </label>
                <label class="field"><span>{{ __('E-mail') }}</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label class="field"><span>{{ __('Telefone') }} <em class="muted">({{ __('opcional') }})</em></span>
                    <input name="phone" value="{{ old('phone') }}" placeholder="(11) 99999-9999">
                </label>
                <label class="field"><span>{{ __('Senha') }}</span>
                    <span class="password-field">
                        <input type="password" name="password" required placeholder="{{ __('Mínimo de 6 caracteres') }}">
                        <button type="button" data-toggle-password aria-label="{{ __('Mostrar senha') }}"><i data-lucide="eye"></i></button>
                    </span>
                </label>
                <label class="field"><span>{{ __('Confirmar senha') }}</span>
                    <input type="password" name="password_confirmation" required>
                </label>
                <button class="btn btn-block" type="submit"><i data-lucide="user-plus"></i> {{ __('Criar conta') }}</button>
            </form>
            <p class="center small muted">{{ __('Já tem conta?') }} <a href="{{ route('login') }}" style="color:var(--orange)">{{ __('Entrar') }}</a></p>
        </div>
    </main>
@endsection
