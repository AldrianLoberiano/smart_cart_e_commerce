<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product listing
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('categories');

        // Category filter
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Price filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $cartItemCount = session('cart', []) ? count(session('cart', [])) : 0;

        return view('products.index', [
            'products' => $products,
            'filters' => $request->all(),
            'cartItemCount' => $cartItemCount,
        ]);
    }

    /**
     * Display single product
     */
    public function show(Product $product)
    {
        $product->load(['categories', 'reviews' => function ($query) {
            $query->where('approved', true)->latest();
        }]);

        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->whereHas('categories', function ($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->limit(4)
            ->get();

        $cartItemCount = session('cart', []) ? count(session('cart', [])) : 0;

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'cartItemCount' => $cartItemCount,
        ]);
    }
}
