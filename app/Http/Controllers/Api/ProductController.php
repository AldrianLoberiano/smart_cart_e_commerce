<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    /**
     * Get product details
     */
    public function show(Product $product): JsonResponse
    {
        $product->load('categories');

        return response()->json($product);
    }

    /**
     * Get product stock
     */
    public function stock($id): JsonResponse
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'stock' => $product->stock,
            'is_in_stock' => $product->isInStock(),
            'is_low_stock' => $product->isLowStock(),
            'track_stock' => $product->track_stock,
        ]);
    }

    /**
     * Search products
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->query('q', '');

        if (strlen($query) < 2) {
            return response()->json(['products' => []]);
        }

        $products = $this->productService->search($query);

        return response()->json([
            'products' => $products
        ]);
    }
}
