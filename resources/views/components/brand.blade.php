@props(['href' => null])

<a href="{{ $href ?? route('home') }}" {{ $attributes->class('site-brand') }} aria-label="Autossencial">
    @include('partials.mark-svg')
    <span class="site-brand-name">AUTOSSENCIAL</span>
</a>
