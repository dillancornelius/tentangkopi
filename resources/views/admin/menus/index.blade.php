<x-layouts.admin title="Menu">
    <x-page-header title="Menu" description="Kelola daftar menu yang tampil di situs.">
        <x-slot:actions>
            <a class="btn btn--primary" href="{{ route('admin.menus.create') }}"><x-icon name="plus" /> Tambah menu</a>
        </x-slot:actions>
    </x-page-header>

    <div class="panel panel--flush">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr><th>Gambar</th><th>Nama</th><th>Kategori</th><th class="num">Harga</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td>
                                @if ($menu->image_url)
                                    <img class="thumb" src="{{ $menu->image_url }}" alt="" loading="lazy">
                                @else
                                    <span class="thumb avatar" aria-hidden="true">{{ mb_substr($menu->name, 0, 1) }}</span>
                                @endif
                            </td>
                            <td><strong>{{ $menu->name }}</strong></td>
                            <td>{{ $menu->subcategory?->category?->name }} / {{ $menu->subcategory?->name }}</td>
                            <td class="num">@rupiah($menu->price)</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn--quiet btn--sm" href="{{ route('admin.menus.edit', $menu) }}">Ubah</a>
                                    <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" data-confirm="Hapus menu {{ $menu->name }}? Riwayat pesanan tetap tersimpan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn--danger btn--sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="muted">Belum ada menu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $menus->links() }}
</x-layouts.admin>
