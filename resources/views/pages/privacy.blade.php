@extends('layouts.base')
@section('title', 'Política de Privacidade — Autossencial')

@section('body')
    <header class="site-nav">
        <div class="wrap nav-inner">
            <x-brand />
            <a class="btn btn-sm" href="{{ route('home') }}">Voltar</a>
        </div>
    </header>
    <main class="section wrap legal">
        <h1>Política de Privacidade</h1>
        <p>A Autossencial usa os dados da conta para identificar o titular, cadastrar veículos, operar o plano, agendar serviços e enviar alertas sobre manutenção e pagamentos.</p>
        <p>Não vendemos esses dados. O acesso ao painel é restrito ao próprio cliente e à equipe administrativa da Autossencial.</p>
        <p>Para pedir correção ou exclusão dos dados, escreva para contato@autossencial.com.br.</p>
    </main>
    @include('partials.footer')
@endsection
