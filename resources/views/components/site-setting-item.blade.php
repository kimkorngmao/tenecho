@props(['item', 'class' => '', 'wrapper' => ''])

@php
    $type = $item->type;
    $value = $item->value;
@endphp

@if ($wrapper)
    <<?= $wrapper ?>>
@endif

    @if ($type === 'text')
        <span class="{{ $class }}">{{ $value }}</span>
    @elseif ($type === 'internal_link' && !empty($item->article?->slug))
        @php
            $link = $item->article->type === 'news'
                ? route('articles.show', $item->article->slug)
                : url($item->article->slug);
        @endphp
        <a href="{{ $link }}" class="{{ $class }}">{{ $value }}</a>
    @elseif ($type === 'external_link' && !empty($item->url))
        <a href="{{ $item->url }}" class="{{ $class }}" target="_blank" rel="noopener">{{ $value }}</a>
    @endif

@if ($wrapper)
    </{{ $wrapper }}>
@endif
