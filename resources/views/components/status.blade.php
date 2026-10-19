@props(['value'])
@php($meta = \App\Support\Labels::status($value))
<span {{ $attributes->merge(['class' => 'badge badge-'.$meta[1]]) }}>{{ $meta[0] }}</span>
