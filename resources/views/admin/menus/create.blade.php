<x-layouts.admin title="Tambah menu">
    <x-page-header title="Tambah menu" />

    <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data" class="panel form-narrow">
        @include('admin.menus._form', ['menu' => null])
    </form>
</x-layouts.admin>
