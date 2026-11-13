<x-layouts.admin title="Ubah menu">
    <x-page-header :title="'Ubah '.$menu->name" />

    <form method="POST" action="{{ route('admin.menus.update', $menu) }}" enctype="multipart/form-data" class="panel form-narrow">
        @method('PUT')
        @include('admin.menus._form')
    </form>
</x-layouts.admin>
