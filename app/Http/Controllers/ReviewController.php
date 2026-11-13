<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Review::with('user')->latest()->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    public function store(ReviewRequest $request): RedirectResponse
    {
        $request->user()->reviews()->create($request->validated());

        return redirect()->route('reviews.index')->with('success', 'Ulasanmu sudah terkirim.');
    }

    public function edit(Review $review): View
    {
        $this->authorize('update', $review);

        return view('reviews.edit', compact('review'));
    }

    public function update(ReviewRequest $request, Review $review): RedirectResponse
    {
        $this->authorize('update', $review);

        $review->update($request->validated());

        return redirect()->route('reviews.index')->with('success', 'Ulasan diperbarui.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $this->authorize('delete', $review);

        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Ulasan dihapus.');
    }
}
