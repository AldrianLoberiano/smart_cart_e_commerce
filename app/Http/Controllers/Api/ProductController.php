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
