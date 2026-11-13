@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title.' | '.config('cafe.name') : config('cafe.name') }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/logo.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">Lewati ke konten</a>

    @include('partials.header')

    <main id="main">
        <div class="container"><x-flash /></div>
        {{ $slot }}
    </main>

    @include('partials.footer')
    @include('partials.cart-drawer')

    <div class="toasts" data-toasts role="status" aria-live="polite"></div>
</body>
</html>
