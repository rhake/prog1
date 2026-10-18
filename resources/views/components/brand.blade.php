@props(['href' => null])

<a href="{{ $href ?? route('home') }}" {{ $attributes->class('site-brand') }} aria-label="Autossencial">
    @include('partials.logo-header-svg')
</a>
