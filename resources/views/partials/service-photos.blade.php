@php
    $photos = $item->photosOf($kind);
@endphp
@if ($photos->isEmpty())
    <p class="small muted">{{ $empty }}</p>
@else
    <div class="photo-grid">
        @foreach ($photos as $photo)
            <figure class="photo-card">
                <a href="{{ $photo->url() }}" target="_blank" rel="noopener">
                    <img src="{{ $photo->url() }}" alt="{{ $photo->caption ?: $photo->kindLabel() }}">
                </a>
                <figcaption>
                    <span>{{ $photo->caption ?: $photo->kindLabel() }}</span>
                    @if (! empty($manage))
                        <form method="post" action="{{ route('admin.services.photos.destroy', [$item, $photo]) }}">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" type="submit">{{ __('Remover') }}</button>
                        </form>
                    @endif
                </figcaption>
            </figure>
        @endforeach
    </div>
@endif
