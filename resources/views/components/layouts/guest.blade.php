@props(['title' => null, 'art' => 'assets/home1.jpg', 'tagline' => 'Sudah ngopi?'])

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
    <div class="auth">
        <div class="auth__art" aria-hidden="true">
            <img src="{{ asset($art) }}" alt="">
            <p>{{ $tagline }}</p>
        </div>
        <main class="auth__panel">
            <div class="auth__card">
                <a class="brand" href="{{ route('home') }}" aria-label="Kembali ke beranda"><img src="{{ asset('assets/logo.jpg') }}" alt="{{ config('cafe.name') }}" width="56" height="56"></a>
                <x-flash />
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
