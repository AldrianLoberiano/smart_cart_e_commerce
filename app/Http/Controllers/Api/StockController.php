<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Check stock levels for multiple products
     */
    public function check(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $stocks = Product::whereIn('id', $validated['product_ids'])
            ->select('id', 'stock', 'track_stock')
            ->get()
            ->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'stock' => $product->stock,
                    'is_in_stock' => $product->isInStock(),
                    'is_low_stock' => $product->isLowStock(),
                ];
            });

        return response()->json([
            'success' => true,
            'stocks' => $stocks,
        ]);
    }

    /**
     * Get real-time stock for a single product
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'product_id' => $product->id,
            'stock' => $product->stock,
            'is_in_stock' => $product->isInStock(),
            'is_low_stock' => $product->isLowStock(),
        ]);
    }
}
