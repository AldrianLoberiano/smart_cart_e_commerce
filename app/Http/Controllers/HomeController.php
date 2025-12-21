<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    /**
     * Display homepage
     */
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with('categories')
            ->limit(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get();

        $cartItemCount = $this->cartService->getItemCount();

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
            'cartItemCount' => $cartItemCount,
        ]);
    }
}
