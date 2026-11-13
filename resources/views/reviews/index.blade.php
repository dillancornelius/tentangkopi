<x-layouts.app title="Ulasan">
    <div class="narrow section">
        <x-page-header title="Ulasan" description="Cerita pelanggan tentang pengalaman mereka di Tentang Kopi." />

        @auth
            <form method="POST" action="{{ route('reviews.store') }}" class="panel">
                @csrf
                <x-form.textarea name="comment" label="Tulis ulasanmu" rows="3" required maxlength="1000" />
                <button type="submit" class="btn btn--dark">Kirim ulasan</button>
            </form>
        @else
            <div class="panel">
                <p><a class="link" href="{{ route('login') }}">Masuk</a> untuk menulis ulasan.</p>
            </div>
        @endauth

        <div class="mt-4">
            @forelse ($reviews as $review)
                <article class="review">
                    <span class="avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($review->user->name, 0, 1)) }}</span>
                    <div>
                        <div class="review__meta">
                            <strong>{{ $review->user->name }}</strong>
                            <span class="review__date">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p>{{ $review->comment }}</p>

                        @can('update', $review)
                            <div class="review__actions">
                                <a class="btn btn--quiet btn--sm" href="{{ route('reviews.edit', $review) }}">Ubah</a>
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" data-confirm="Hapus ulasan ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--quiet btn--sm">Hapus</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </article>
            @empty
                <div class="empty">
                    <h2>Belum ada ulasan</h2>
                    <p>Jadilah yang pertama bercerita.</p>
                </div>
            @endforelse
        </div>

        {{ $reviews->links() }}
    </div>
</x-layouts.app>
