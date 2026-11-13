<x-layouts.admin title="Tambah pengguna">
    <x-page-header title="Tambah pengguna" />

    <form method="POST" action="{{ route('admin.users.store') }}" class="panel form-narrow">
        @include('admin.users._form', ['user' => null])
    </form>
</x-layouts.admin>
