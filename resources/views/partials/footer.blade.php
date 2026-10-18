<footer class="site-footer">
    <div class="wrap footer-grid">
        <nav class="footer-col" aria-label="Serviços">
            <h2>Serviços</h2>
            <a href="{{ route('home') }}#planos">Guincho 24h</a>
            <a href="{{ route('home') }}#planos">Troca de óleo</a>
            <a href="{{ route('home') }}#planos">Inspeção de freios</a>
            <a href="{{ route('home') }}#planos">Alinhamento</a>
            <a href="{{ route('home') }}#planos">Check-up</a>
            <a href="{{ route('home') }}#planos">Diagnóstico</a>
        </nav>

        <nav class="footer-col" aria-label="Links importantes">
            <h2>Links importantes</h2>
            <a href="{{ route('home') }}#sobre">Sobre</a>
            <a href="mailto:parceiros@autossencial.com.br">Seja um parceiro</a>
            <a href="{{ route('home') }}#planos">Descritivos dos serviços</a>
            <a href="{{ route('home') }}#perguntas">Perguntas frequentes</a>
            <a href="{{ route('privacy') }}">Política de Privacidade</a>
            <a href="{{ route('terms') }}">Termos de Uso</a>
        </nav>

        <div class="footer-col footer-help">
            <h2>Precisa de ajuda?</h2>
            <a href="mailto:contato@autossencial.com.br"><i data-lucide="message-circle"></i> Fale com a gente</a>
            <a href="{{ route('home') }}#planos"><i data-lucide="map-pin"></i> Pontos de atendimento</a>

            <h2 class="footer-gap">Novo por aqui?</h2>
            <a href="{{ route('register') }}"><i data-lucide="repeat"></i> Assine agora</a>

            <div class="footer-social" id="redes">
                <a href="#redes" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                <a href="#redes" aria-label="LinkedIn"><i data-lucide="linkedin"></i></a>
                <a href="#redes" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                <a href="#redes" aria-label="YouTube"><i data-lucide="youtube"></i></a>
            </div>
        </div>
    </div>

    <div class="wrap footer-bar">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="footer-logo" alt="Autossencial">
        </a>
        <p>© {{ date('Y') }} Autossencial · Plano de saúde veicular</p>
        <div class="footer-seal">
            <img src="{{ asset('images/mark-light.png') }}" alt="">
            <span>Plano de saúde<br><strong>veicular</strong></span>
        </div>
    </div>
</footer>
