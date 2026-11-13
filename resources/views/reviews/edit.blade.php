<x-layouts.app title="Ubah ulasan">
    <div class="narrow section">
        <x-page-header title="Ubah ulasan" />

        <form method="POST" action="{{ route('reviews.update', $review) }}" class="panel">
            @csrf
            @method('PUT')
            <x-form.textarea name="comment" label="Ulasan" :value="$review->comment" rows="4" required maxlength="1000" />

            <div class="form-actions">
                <button type="submit" class="btn btn--dark">Simpan</button>
                <a class="btn btn--quiet" href="{{ route('reviews.index') }}">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.app>
