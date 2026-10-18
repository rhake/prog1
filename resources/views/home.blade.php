@extends('layouts.base')
@section('title', 'Autossencial — '.__('Plano de saúde veicular'))

@section('body')
    <header class="site-nav">
        <div class="wrap nav-inner">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" class="brand-logo logo-dark" alt="Autossencial">
                <img src="{{ asset('images/logo-light.png') }}" class="brand-logo logo-light" alt="Autossencial">
            </a>
            <div class="nav-actions">
                <a class="icon-btn" href="{{ route('theme') }}" aria-label="{{ __('Tema') }}"><i data-lucide="sun-moon"></i></a>
                @auth
                    <a class="btn btn-sm" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('app.home') }}">
                        {{ __('Acessar painel') }} <i data-lucide="arrow-right"></i>
                    </a>
                @else
                    <a class="btn btn-ghost btn-sm" href="{{ route('login') }}">{{ __('Entrar') }}</a>
                    <a class="btn btn-sm" href="{{ route('register') }}">{{ __('Cadastrar') }} <i data-lucide="arrow-right"></i></a>
                @endauth
            </div>
        </div>
    </header>

    <section class="hero wrap">
        <img src="{{ asset('images/logo.png') }}" class="hero-logo logo-dark" alt="Autossencial">
        <img src="{{ asset('images/logo-light.png') }}" class="hero-logo logo-light" alt="Autossencial">
        <div class="pill"><i data-lucide="shield"></i> {{ __('Plano de saúde veicular') }}</div>
        <h1>Procure um ponto<br>de atendimento <span>mais próximo</span></h1>
        <p class="lead">{{ __('Manutenção, proteção e rastreamento em um plano só. A Autossencial acompanha cada veículo da sua garagem.') }}</p>
        <div class="hero-actions">
            @auth
                <a class="btn btn-lg" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('app.home') }}">{{ __('Acessar painel') }} <i data-lucide="arrow-right"></i></a>
            @else
                <a class="btn btn-lg" href="{{ route('register') }}">{{ __('Começar agora') }} <i data-lucide="arrow-right"></i></a>
                <a class="btn btn-lg btn-outline" href="{{ route('login') }}">{{ __('Já tenho conta') }}</a>
            @endauth
        </div>
    </section>

    <section class="section" id="sobre" style="background:var(--bg-2)">
        <div class="wrap">
            <h2>{{ __('O essencial do seu carro') }}</h2>
            <p class="intro">{{ __('Tudo que um plano de saúde veicular precisa entregar.') }}</p>
            <div class="features">
                @foreach ([
                    ['map-pin', __('Rastreamento'), __('Veja onde o veículo está, com atualização pelo rastreador.')],
                    ['wrench', __('Manutenção'), __('Agende serviços nas oficinas parceiras da sua região.')],
                    ['shield', __('Proteção'), __('Planos com cobertura, assistência e limites claros.')],
                    ['credit-card', __('Pagamentos'), __('Acompanhe a mensalidade e o histórico do plano.')],
                    ['bell', __('Alertas'), __('Avisos de revisão, pagamento e andamento do serviço.')],
                    ['car', __('Sua garagem'), __('Cadastre mais de um veículo na mesma conta.')],
                ] as [$icon, $title, $text])
                    <article class="card feature">
                        <div class="bubble"><i data-lucide="{{ $icon }}"></i></div>
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="planos">
        <div class="wrap">
            <h2>{{ __('Planos') }}</h2>
            <p class="intro">{{ __('Escolha a cobertura do seu veículo.') }}</p>
            <div class="plans plans-showcase">
                @forelse ($plans as $plan)
                    <article class="card plan {{ $plan->isPopular() ? 'popular' : '' }}">
                        @if ($plan->isPopular())
                            <span class="popular-tag">{{ __('Popular') }}</span>
                        @endif
                        <h3>{{ $plan->plan_name }}</h3>
                        <div class="price">@money($plan->monthly_price) <span>/{{ __('mês') }}</span></div>
                        <p class="muted small">{{ $plan->description }}</p>
                        <ul>
                            @foreach ($plan->services_included as $item)
                                <li><i data-lucide="check"></i> {{ $item }}</li>
                            @endforeach
                            <li><i data-lucide="check"></i> {{ $plan->max_services_per_year }} {{ __('serviços/ano') }}</li>
                        </ul>
                        <a class="btn {{ $plan->isPopular() ? '' : 'btn-outline' }}" href="{{ route('register') }}">{{ __('Assinar') }}</a>
                    </article>
                @empty
                    <p class="muted">{{ __('Os planos aparecem aqui depois da configuração inicial.') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section" style="background:var(--bg-2)">
        <div class="wrap">
            <h2>{{ __('Quem já usa') }}</h2>
            <div class="quotes">
                @foreach ([
                    ['Carlos S.', __('Consigo ver revisão, plano e localização do carro no mesmo lugar.'), 5],
                    ['Ana O.', __('O plano Premium me salvou com o guincho. Vale cada mensalidade.'), 5],
                    ['Pedro L.', __('Agendar a oficina ficou direto. Sem telefone e sem surpresa.'), 4],
                ] as [$name, $text, $stars])
                    <article class="card">
                        <div class="stars">{{ str_repeat('★', $stars) }}{{ str_repeat('☆', 5 - $stars) }}</div>
                        <p style="margin:10px 0">“{{ $text }}”</p>
                        <strong>{{ $name }}</strong>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="perguntas" style="background:var(--bg-2)">
        <div class="wrap">
            <h2>Perguntas frequentes</h2>
            <div class="faq">
                <article class="card">
                    <h3>O que o plano cobre?</h3>
                    <p class="muted">Manutenção nas oficinas parceiras, alertas e, nos planos superiores, rastreamento e guincho. O detalhe de cada cobertura está na lista do plano.</p>
                </article>
                <article class="card">
                    <h3>Como acho um ponto de atendimento?</h3>
                    <p class="muted">Depois do cadastro, o mapa mostra as oficinas e os rastreadores vinculados aos seus veículos.</p>
                </article>
                <article class="card">
                    <h3>Posso ter mais de um carro?</h3>
                    <p class="muted">Sim. Cada veículo entra na sua garagem e pode ter o próprio plano.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="cta">
                <h2>{{ __('Pronto para cuidar do seu veículo?') }}</h2>
                <p>{{ __('Crie sua conta e coloque o carro em um plano de saúde veicular.') }}</p>
                <div class="cta-actions">
                    <a class="btn btn-lg btn-account" href="{{ route('register') }}">Criar conta</a>
                    <a class="btn btn-lg btn-whatsapp" href="https://wa.me/?text={{ rawurlencode('Olá, quero falar com um consultor da Autossencial') }}" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M20.5 3.5A11 11 0 0 0 2.1 16.8L1 23l6.4-1.1A11 11 0 0 0 12 23a11 11 0 0 0 8.5-19.5zM12 21a9 9 0 0 1-4.6-1.3l-.3-.2-3.8.6.7-3.7-.2-.3A9 9 0 1 1 12 21zm5-6.8c-.3-.1-1.6-.8-1.8-.9s-.4-.1-.6.1-.7.9-.8 1-.3.2-.6.1a7.4 7.4 0 0 1-2.2-1.4 8.2 8.2 0 0 1-1.5-1.9c-.2-.3 0-.4.1-.6l.4-.4.2-.4a.5.5 0 0 0 0-.5c-.1-.1-.6-1.4-.8-1.9s-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.7 11.8 11.8 0 0 0 4.6 4.1c.6.2 1 .4 1.5.5a3.6 3.6 0 0 0 1.7.1 2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .2-1.3c-.1-.2-.3-.2-.6-.3z"/></svg>
                        Falar com um consultor
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
