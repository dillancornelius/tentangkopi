<x-layouts.admin title="Ubah pengguna">
    <x-page-header :title="'Ubah '.$user->name" />

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="panel form-narrow">
        @method('PUT')
        @include('admin.users._form')
    </form>
</x-layouts.admin>
