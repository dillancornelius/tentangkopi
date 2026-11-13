@props(['title', 'description' => null])

<div class="page-head">
    <div>
        <h1>{{ $title }}</h1>
        @if ($description)
            <p>{{ $description }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="page-head__actions">{{ $actions }}</div>
    @endisset
</div>
