<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cartData = $this->cartService->getCartData();

        return view('cart.index', [
            'items' => $cartData['items'],
            'subtotal' => $cartData['subtotal'],
            'tax' => $cartData['tax'],
            'total' => $cartData['total'],
            'itemCount' => $cartData['item_count'],
        ]);
    }

    /**
     * Add item to cart (for non-AJAX requests)
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        try {
            $this->cartService->addItem(
                $validated['product_id'],
                $validated['quantity']
            );

            return redirect()->back()->with('success', 'Item added to cart successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update cart item quantity (for non-AJAX requests)
     */
    public function update(Request $request, string $itemKey)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        try {
            if ($validated['quantity'] == 0) {
                $this->cartService->removeItem($itemKey);
                return redirect()->back()->with('success', 'Item removed from cart');
            }

            $this->cartService->updateQuantity($itemKey, $validated['quantity']);
            return redirect()->back()->with('success', 'Cart updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove item from cart (for non-AJAX requests)
     */
    public function remove(string $itemKey)
    {
        try {
            $this->cartService->removeItem($itemKey);
            return redirect()->back()->with('success', 'Item removed from cart');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $this->cartService->clear();
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }
}
