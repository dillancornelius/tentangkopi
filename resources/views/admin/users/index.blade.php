<x-layouts.admin title="Pengguna">
    <x-page-header title="Pengguna" description="Kelola akun pelanggan dan admin.">
        <x-slot:actions>
            <a class="btn btn--primary" href="{{ route('admin.users.create') }}"><x-icon name="plus" /> Tambah pengguna</a>
        </x-slot:actions>
    </x-page-header>

    <div class="panel panel--flush">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge {{ $user->isAdmin() ? 'badge--info' : 'badge--neutral' }}">{{ $user->role->label() }}</span></td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn--quiet btn--sm" href="{{ route('admin.users.edit', $user) }}">Ubah</a>
                                    @unless ($user->is(auth()->user()))
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" data-confirm="Hapus pengguna {{ $user->name }}?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn--danger btn--sm">Hapus</button>
                                        </form>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links() }}
</x-layouts.admin>
