@props(['title' => 'Admin'])

@php
    $nav = [
        ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'layout', 'label' => 'Dashboard'],
        ['route' => 'admin.orders.index', 'match' => 'admin.orders.*', 'icon' => 'receipt', 'label' => 'Pesanan'],
        ['route' => 'admin.menus.index', 'match' => 'admin.menus.*', 'icon' => 'coffee', 'label' => 'Menu'],
        ['route' => 'admin.users.index', 'match' => 'admin.users.*', 'icon' => 'users', 'label' => 'Pengguna'],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | Admin {{ config('cafe.name') }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/logo.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar" id="admin-sidebar" data-sidebar>
            <div class="admin-brand">
                <img src="{{ asset('assets/logo.jpg') }}" alt="">
                <span>{{ config('cafe.name') }}<small>Panel admin</small></span>
            </div>

            <nav class="admin-nav" aria-label="Admin">
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}" @class(['is-active' => request()->routeIs($item['match'])]) @if (request()->routeIs($item['match'])) aria-current="page" @endif>
                        <x-icon :name="$item['icon']" /> {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="admin-sidebar__foot">
                <p class="admin-sidebar__who">{{ auth()->user()->email }}</p>
                <form method="POST" action="{{ route('logout') }}" class="admin-nav">
                    @csrf
                    <button type="submit"><x-icon name="logout" /> Keluar</button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <div class="admin-topbar">
                <button type="button" class="icon-btn" data-sidebar-toggle aria-controls="admin-sidebar" aria-expanded="false" aria-label="Buka navigasi"><x-icon name="menu" /></button>
                <strong>{{ $title }}</strong>
            </div>

            <main class="admin-content">
                <x-flash />
                {{ $slot }}
            </main>
        </div>
    </div>

    <div class="toasts" data-toasts role="status" aria-live="polite"></div>
</body>
</html>
