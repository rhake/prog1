@extends('layouts.base')
@section('title', 'Termos de Uso — Autossencial')

@section('body')
    <header class="site-nav">
        <div class="wrap nav-inner">
            <x-brand />
            <a class="btn btn-sm" href="{{ route('home') }}">Voltar</a>
        </div>
    </header>
    <main class="section wrap legal">
        <h1>Termos de Uso</h1>
        <p>Ao criar uma conta, você informa dados verdadeiros do titular e dos veículos. O plano cobre os serviços descritos na contratação, dentro do limite anual de cada assinatura.</p>
        <p>Agendamentos dependem da oficina escolhida e podem ser acompanhados pelo painel. O cancelamento de uma solicitação vale enquanto ela ainda não estiver em andamento.</p>
        <p>Dúvidas sobre estes termos: contato@autossencial.com.br.</p>
    </main>
    @include('partials.footer')
@endsection
