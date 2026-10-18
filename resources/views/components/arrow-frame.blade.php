@props(['color' => 'white'])

<div {{ $attributes->class(['arrow-frame', 'arrow-frame-orange' => $color === 'orange']) }}>
    <span class="arrow tl" aria-hidden="true"></span>
    <span class="arrow tr" aria-hidden="true"></span>
    <span class="arrow bl" aria-hidden="true"></span>
    <span class="arrow br" aria-hidden="true"></span>
    <div class="arrow-frame-text">{{ $slot }}</div>
</div>
