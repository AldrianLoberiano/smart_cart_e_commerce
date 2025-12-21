<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    /**
     * Get cart data
     */
    public function index(): JsonResponse
    {
        return response()->json($this->cartService->getCartData());
    }

    /**
     * Add item to cart
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1|max:99',
            ]);

            $cart = $this->cartService->addItem(
                $validated['product_id'],
                $validated['quantity']
            );

            return response()->json($cart);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, string $itemKey): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        try {
            $cart = $this->cartService->updateQuantity(
                $itemKey,
                $validated['quantity']
            );

            return response()->json($cart);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove item from cart
     */
    public function destroy(string $itemKey): JsonResponse
    {
        try {
            $cart = $this->cartService->removeItem($itemKey);
            return response()->json($cart);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Clear cart
     */
    public function clear(): JsonResponse
    {
        $this->cartService->clear();
        return response()->json([
            'message' => 'Cart cleared successfully'
        ]);
    }
}
