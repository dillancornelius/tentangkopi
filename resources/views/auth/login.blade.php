<x-layouts.guest title="Masuk" art="assets/home1.jpg" tagline="Sudah ngopi?">
    <h1>Masuk</h1>
    <p>Lanjutkan pesananmu atau lihat riwayat pesanan.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <x-form.input name="email" label="Email" type="email" required autofocus autocomplete="username" />
        <x-form.input name="password" label="Password" type="password" required autocomplete="current-password" />

        <label class="check">
            <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
            Ingat saya di perangkat ini
        </label>

        <button type="submit" class="btn btn--dark btn--block mt-4">Masuk</button>
    </form>

    <p class="auth__alt">Belum punya akun? <a class="link" href="{{ route('register') }}">Daftar</a></p>
</x-layouts.guest>
