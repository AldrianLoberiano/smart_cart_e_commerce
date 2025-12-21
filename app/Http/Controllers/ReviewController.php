<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Apply authentication middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new review
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product');
        }

        // Check if user purchased this product
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $hasPurchased = $user
            ->orders()
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', 'delivered')
            ->exists();

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'is_verified' => $hasPurchased,
            'is_approved' => true, // Auto-approve for now
        ]);

        return back()->with('success', 'Review submitted successfully');
    }

    /**
     * Update review
     */
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully');
    }

    /**
     * Delete review
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully');
    }
}
