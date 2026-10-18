@props(['href' => null])

<a href="{{ $href ?? route('home') }}" {{ $attributes->class('site-brand') }} aria-label="Autossencial">
    <img src="{{ asset('images/mark.png') }}" class="site-brand-mark logo-dark" alt="" width="2288" height="2144">
    <img src="{{ asset('images/mark-light.png') }}" class="site-brand-mark logo-light" alt="" width="2288" height="2144">
    <span class="site-brand-name">AUTOSSENCIAL</span>
</a>
