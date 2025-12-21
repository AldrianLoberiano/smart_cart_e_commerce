<?php

namespace App\Services;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get cart items
     */
    public function getItems(): array
    {
        $items = [];

        if (Auth::check()) {
            // Get cart items from database for logged-in users
            $cartItems = CartItem::where('user_id', Auth::id())
                ->with(['product' => function ($query) {
                    $query->withTrashed(); // Include soft-deleted products
                }])
                ->get();

            foreach ($cartItems as $item) {
                if ($item->product) {
                    $items["product_{$item->product_id}"] = [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'slug' => $item->product->slug,
                        'price' => (float) $item->price,
                        'image' => $item->product->primary_image ?? 'https://placehold.co/600x400?text=No+Image',
                        'quantity' => $item->quantity,
                        'is_active' => $item->product->is_active ?? false,
                    ];
                }
            }
        } else {
            // Get cart from session for guest users
            $sessionId = Session::getId();
            $cartItems = CartItem::where('session_id', $sessionId)
                ->with(['product' => function ($query) {
                    $query->withTrashed(); // Include soft-deleted products
                }])
                ->get();

            foreach ($cartItems as $item) {
                if ($item->product) {
                    $items["product_{$item->product_id}"] = [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'slug' => $item->product->slug,
                        'price' => (float) $item->price,
                        'image' => $item->product->primary_image ?? 'https://placehold.co/600x400?text=No+Image',
                        'quantity' => $item->quantity,
                        'is_active' => $item->product->is_active ?? false,
                    ];
                }
            }
        }

        return $items;
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

        if (Auth::check()) {
            // Add to database for logged-in users
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;

                if ($product->track_stock && $newQuantity > $product->stock) {
                    throw new \Exception('Not enough stock available');
                }

                $cartItem->update(['quantity' => $newQuantity]);
            } else {
                if ($product->track_stock && $quantity > $product->stock) {
                    throw new \Exception('Not enough stock available');
                }

                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }
        } else {
            // Add to database with session ID for guest users
            $sessionId = Session::getId();

            $cartItem = CartItem::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;

                if ($product->track_stock && $newQuantity > $product->stock) {
                    throw new \Exception('Not enough stock available');
                }

                $cartItem->update(['quantity' => $newQuantity]);
            } else {
                if ($product->track_stock && $quantity > $product->stock) {
                    throw new \Exception('Not enough stock available');
                }

                CartItem::create([
                    'session_id' => $sessionId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }
        }

        return $this->getCartData();
    }

    /**
     * Update item quantity
     */
    public function updateQuantity(string $itemKey, int $quantity): array
    {
        if ($quantity <= 0) {
            return $this->removeItem($itemKey);
        }

        $productId = (int) str_replace('product_', '', $itemKey);

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->with(['product' => function ($query) {
                    $query->withTrashed();
                }])
                ->first();
        } else {
            $sessionId = Session::getId();
            $cartItem = CartItem::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->with(['product' => function ($query) {
                    $query->withTrashed();
                }])
                ->first();
        }

        if (!$cartItem) {
            throw new \Exception('Item not found in cart');
        }

        $product = $cartItem->product;
        if ($product && $product->track_stock && $quantity > $product->stock) {
            throw new \Exception('Not enough stock available');
        }

        $cartItem->update(['quantity' => $quantity]);

        return $this->getCartData();
    }

    /**
     * Remove item from cart
     */
    public function removeItem(string $itemKey): array
    {
        $productId = (int) str_replace('product_', '', $itemKey);

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $sessionId = Session::getId();
            CartItem::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->delete();
        }

        return $this->getCartData();
    }

    /**
     * Clear entire cart
     */
    public function clear(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            $sessionId = Session::getId();
            CartItem::where('session_id', $sessionId)->delete();
        }
    }

    /**
     * Get cart data with calculations
     */
    public function getCartData(): array
    {
        // Clean up orphaned cart items (products that no longer exist)
        $this->cleanOrphanedItems();

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
     * Clean up cart items with deleted/missing products
     */
    private function cleanOrphanedItems(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->whereDoesntHave('product')
                ->delete();
        } else {
            $sessionId = Session::getId();
            CartItem::where('session_id', $sessionId)
                ->whereDoesntHave('product')
                ->delete();
        }
    }

    /**
     * Get item count
     */
    public function getItemCount(): int
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->sum('quantity') ?? 0;
        } else {
            $sessionId = Session::getId();
            return CartItem::where('session_id', $sessionId)->sum('quantity') ?? 0;
        }
    }

    /**
     * Merge guest cart with user cart on login
     */
    public function mergeGuestCart(int $userId): void
    {
        $sessionId = Session::getId();

        $guestItems = CartItem::where('session_id', $sessionId)->get();

        foreach ($guestItems as $guestItem) {
            $userItem = CartItem::where('user_id', $userId)
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($userItem) {
                // Merge quantities
                $userItem->update([
                    'quantity' => $userItem->quantity + $guestItem->quantity
                ]);
                $guestItem->delete();
            } else {
                // Transfer to user
                $guestItem->update([
                    'user_id' => $userId,
                    'session_id' => null
                ]);
            }
        }
    }
}
