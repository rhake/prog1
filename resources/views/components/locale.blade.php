<div class="lang" aria-label="{{ __('Idioma') }}">
    <a href="{{ route('locale', 'pt') }}" class="{{ app()->getLocale() === 'pt' ? 'on' : '' }}">PT</a>
    <a href="{{ route('locale', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'on' : '' }}">EN</a>
</div>
