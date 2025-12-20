<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const CART_SESSION_KEY = 'shopping_cart';

    /**
     * Get cart items
     */
    public function getItems(): array
    {
        return Session::get(self::CART_SESSION_KEY, []);
    }

    /**
     * Add item to cart
     */
    public function addItem(int $productId, int $quantity = 1): array
    {
        $product = Product::findOrFail($productId);

        if (!$product->isInStock()) {
            throw new \Exception('Product is out of stock');
        }

        $cart = $this->getItems();
        $itemKey = "product_{$productId}";

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $quantity;
        } else {
            $cart[$itemKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => $product->primary_image,
                'quantity' => $quantity,
            ];
        }

        // Check stock availability
        if ($product->track_stock && $cart[$itemKey]['quantity'] > $product->stock) {
            throw new \Exception('Not enough stock available');
        }

        Session::put(self::CART_SESSION_KEY, $cart);

        return $this->getCartData();
    }

    /**
     * Update item quantity
     */
    public function updateQuantity(string $itemKey, int $quantity): array
    {
        $cart = $this->getItems();

        if (!isset($cart[$itemKey])) {
            throw new \Exception('Item not found in cart');
        }

        if ($quantity <= 0) {
            return $this->removeItem($itemKey);
        }

        // Verify stock
        $product = Product::find($cart[$itemKey]['id']);
        if ($product && $product->track_stock && $quantity > $product->stock) {
            throw new \Exception('Not enough stock available');
        }

        $cart[$itemKey]['quantity'] = $quantity;
        Session::put(self::CART_SESSION_KEY, $cart);

        return $this->getCartData();
    }

    /**
     * Remove item from cart
     */
    public function removeItem(string $itemKey): array
    {
        $cart = $this->getItems();
        unset($cart[$itemKey]);
        Session::put(self::CART_SESSION_KEY, $cart);

        return $this->getCartData();
    }

    /**
     * Clear entire cart
     */
    public function clear(): void
    {
        Session::forget(self::CART_SESSION_KEY);
    }

    /**
     * Get cart data with calculations
     */
    public function getCartData(): array
    {
        $items = $this->getItems();
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax = $subtotal * 0.08; // 8% tax
        $total = $subtotal + $tax;

        return [
            'items' => array_values($items),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'item_count' => array_sum(array_column($items, 'quantity')),
        ];
    }

    /**
     * Get item count
     */
    public function getItemCount(): int
    {
        $items = $this->getItems();
        return array_sum(array_column($items, 'quantity'));
    }
}
