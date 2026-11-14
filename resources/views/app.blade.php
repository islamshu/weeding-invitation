@php
    $locale = $page['props']['locale'] ?? 'ar';
    $meta = $page['props']['meta'] ?? [];
    $title = $meta['title'] ?? config('app.name', 'دعوة');
    $description = $meta['description'] ?? 'منصة أنيقة لابتكار دعوات زفاف عربية فاخرة ومشاركتها برابط واحد.';
    $image = $meta['image'] ?? null;
    $canonical = $meta['url'] ?? url()->current();
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="theme-color" content="#6d1f33">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:locale" content="{{ $meta['locale'] ?? 'ar_AR' }}">
    @if (! empty($meta['alternate_locale']))
        <meta property="og:locale:alternate" content="{{ $meta['alternate_locale'] }}">
    @endif
    @if ($image)
        <meta property="og:image" content="{{ $image }}">
        <meta property="og:image:alt" content="{{ $title }}">
    @endif

    <meta name="twitter:card" content="{{ $image ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    @if ($image)
        <meta name="twitter:image" content="{{ $image }}">
    @endif

    <link rel="canonical" href="{{ $canonical }}">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#fbf7f0] text-[#2f2a24] antialiased">
    @inertia
</body>
</html>
