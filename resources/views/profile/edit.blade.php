<x-layouts.app title="Profil">
    <div class="narrow section">
        <x-page-header title="Profil" description="Kelola data akun dan keamananmu." />

        <form method="POST" action="{{ route('profile.update') }}" class="panel">
            @csrf
            @method('PUT')
            <h2>Data akun</h2>

            <x-form.input name="name" label="Nama" :value="$user->name" required autocomplete="name" />
            <x-form.input name="email" label="Email" type="email" :value="$user->email" required autocomplete="username" />

            <h2 class="mt-4">Ganti password</h2>
            <x-form.input name="current_password" label="Password saat ini" type="password" autocomplete="current-password" hint="Isi hanya jika ingin mengganti password." />
            <x-form.input name="password" label="Password baru" type="password" autocomplete="new-password" hint="Minimal 8 karakter." />
            <x-form.input name="password_confirmation" label="Ulangi password baru" type="password" autocomplete="new-password" />

            <button type="submit" class="btn btn--dark">Simpan perubahan</button>
        </form>

        <form method="POST" action="{{ route('profile.destroy') }}" class="panel panel--danger" data-confirm="Hapus akun secara permanen? Tindakan ini tidak bisa dibatalkan.">
            @csrf
            @method('DELETE')
            <h2>Hapus akun</h2>
            <p class="muted">Akun dan ulasanmu akan dihapus permanen. Riwayat pesanan tetap tersimpan tanpa nama akunmu.</p>

            <div class="mt-4">
                <x-form.input name="password" id="delete_password" label="Konfirmasi dengan password" type="password" bag="userDeletion" required autocomplete="current-password" />
            </div>

            <button type="submit" class="btn btn--danger">Hapus akun saya</button>
        </form>
    </div>
</x-layouts.app>
