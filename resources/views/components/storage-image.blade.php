@props(['path' => null, 'alt' => 'Product image'])
@php
    $fallbackImage = asset('img/logo-3.png');
    $imageUrl = $path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)
        ? \Illuminate\Support\Facades\Storage::url($path)
        : $fallbackImage;
@endphp
<img {{ $attributes }} src="{{ $imageUrl }}" alt="{{ $alt }}" onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
