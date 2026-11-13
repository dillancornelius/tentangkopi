@props(['name', 'label', 'value' => null, 'hint' => null, 'bag' => 'default'])

@php
    $error = $errors->getBag($bag)->first($name);
@endphp

<div @class(['field', 'has-error' => $error])>
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        @if ($error) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>

    @if ($hint && ! $error)
        <p class="field__hint">{{ $hint }}</p>
    @endif
    @if ($error)
        <p class="field__error" id="{{ $name }}-error">{{ $error }}</p>
    @endif
</div>
