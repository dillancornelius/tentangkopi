@csrf

<x-form.input name="name" label="Nama menu" :value="$menu?->name" required />
<x-form.input name="price" label="Harga (Rp)" type="number" :value="$menu?->price" min="0" step="500" inputmode="numeric" required />

<x-form.select name="subcategory_id" label="Kategori" required>
    <option value="">Pilih kategori</option>
    @foreach ($categories as $category)
        <optgroup label="{{ $category->name }}">
            @foreach ($category->subcategories as $subcategory)
                <option value="{{ $subcategory->id }}" @selected((string) old('subcategory_id', $menu?->subcategory_id) === (string) $subcategory->id)>{{ $subcategory->name }}</option>
            @endforeach
        </optgroup>
    @endforeach
</x-form.select>

<x-form.textarea name="description" label="Deskripsi (opsional)" :value="$menu?->description" rows="3" maxlength="1000" />

<div class="field">
    <label for="image">Gambar (opsional)</label>
    @if ($menu?->image_url)
        <img class="image-preview" src="{{ $menu->image_url }}" alt="Gambar saat ini">
    @endif
    <input id="image" type="file" name="image" accept="image/png,image/jpeg,image/webp">
    <p class="field__hint">JPG, PNG, atau WebP, maksimal 2 MB. PNG transparan paling bagus untuk kartu menu.</p>
    @error('image')
        <p class="field__error">{{ $message }}</p>
    @enderror
</div>

<div class="form-actions">
    <button type="submit" class="btn btn--dark">Simpan</button>
    <a class="btn btn--quiet" href="{{ route('admin.menus.index') }}">Batal</a>
</div>
