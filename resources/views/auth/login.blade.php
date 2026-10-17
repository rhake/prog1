@extends('layouts.base')
@section('title', __('Entrar').' — Autossencial')

@section('body')
    <main class="auth">
        <div class="auth-card">
            <a href="{{ route('home') }}" class="small muted" style="display:inline-flex;gap:6px;align-items:center"><i data-lucide="arrow-left"></i> {{ __('Voltar') }}</a>
            <img src="{{ asset('images/logo.png') }}" class="auth-logo logo-dark" alt="Autossencial">
            <img src="{{ asset('images/logo-light.png') }}" class="auth-logo logo-light" alt="Autossencial">
            <div class="center">
                <h1 style="font-size:1.6rem">{{ __('Entrar') }}</h1>
                <p class="muted">{{ __('Acesse sua conta Autossencial.') }}</p>
            </div>
            <form class="card stack" method="post" action="{{ route('login') }}">
                @csrf
                @include('partials.flashes')
                <label class="field"><span>{{ __('E-mail') }}</span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required autofocus>
                </label>
                <label class="field"><span>{{ __('Senha') }}</span>
                    <span class="password-field">
                        <input type="password" name="password" required>
                        <button type="button" data-toggle-password aria-label="{{ __('Mostrar senha') }}"><i data-lucide="eye"></i></button>
                    </span>
                </label>
                <button class="btn btn-block" type="submit"><i data-lucide="log-in"></i> {{ __('Entrar') }}</button>
            </form>
            <p class="center small muted">{{ __('Não tem conta?') }} <a href="{{ route('register') }}" style="color:var(--orange)">{{ __('Cadastre-se') }}</a></p>
            <div class="hint">
                <strong>{{ __('Contas de demonstração') }}</strong>
                <p>{{ __('Admin') }}: admin@autossencial.com / admin123</p>
                <p>{{ __('Cliente') }}: carlos@email.com / user123</p>
            </div>
        </div>
    </main>
@endsection
