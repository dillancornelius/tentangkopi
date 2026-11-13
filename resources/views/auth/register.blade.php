<x-layouts.guest title="Daftar" art="assets/home2.jpg" tagline="Yuk, ngopi bareng.">
    <h1>Buat akun</h1>
    <p>Daftar sekali, pesan kapan saja.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <x-form.input name="name" label="Nama" required autofocus autocomplete="name" />
        <x-form.input name="email" label="Email" type="email" required autocomplete="username" />
        <x-form.input name="password" label="Password" type="password" required autocomplete="new-password" hint="Minimal 8 karakter." />

        <button type="submit" class="btn btn--dark btn--block mt-4">Daftar</button>
    </form>

    <p class="auth__alt">Sudah punya akun? <a class="link" href="{{ route('login') }}">Masuk</a></p>
</x-layouts.guest>
