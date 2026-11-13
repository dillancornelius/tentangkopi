@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null, 'bag' => 'default'])

@php
    $id = $attributes->get('id', $name);
    $error = $errors->getBag($bag)->first($name);
    $keepValue = ! in_array($type, ['password', 'file'], true);
@endphp

<div @class(['field', 'has-error' => $error])>
    <label for="{{ $id }}">{{ $label }}</label>

    @if ($type === 'password')
        <div class="password-wrap">
    @endif

    <input
        id="{{ $id }}"
        type="{{ $type }}"
        name="{{ $name }}"
        @if ($keepValue) value="{{ old($name, $value) }}" @endif
        @if ($error) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif
        {{ $attributes->except('id') }}
    >

    @if ($type === 'password')
            <button type="button" class="icon-btn" data-toggle-password="{{ $id }}" aria-label="Tampilkan password"><x-icon name="eye" /></button>
        </div>
    @endif

    @if ($hint && ! $error)
        <p class="field__hint">{{ $hint }}</p>
    @endif
    @if ($error)
        <p class="field__error" id="{{ $id }}-error">{{ $error }}</p>
    @endif
</div>
