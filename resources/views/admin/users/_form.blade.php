@csrf

<x-form.input name="name" label="Nama" :value="$user?->name" required />
<x-form.input name="email" label="Email" type="email" :value="$user?->email" required />
<x-form.input name="password" label="Password" type="password" :required="! $user" autocomplete="new-password" :hint="$user ? 'Kosongkan jika tidak ingin mengganti password.' : 'Minimal 8 karakter.'" />

<x-form.select name="role" label="Role" required>
    @foreach (\App\Enums\UserRole::cases() as $role)
        <option value="{{ $role->value }}" @selected(old('role', $user?->role?->value ?? 'user') === $role->value)>{{ $role->label() }}</option>
    @endforeach
</x-form.select>

<div class="form-actions">
    <button type="submit" class="btn btn--dark">Simpan</button>
    <a class="btn btn--quiet" href="{{ route('admin.users.index') }}">Batal</a>
</div>
