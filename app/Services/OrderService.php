<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private CartService $cartService
    ) {}

    /**
     * Create order from cart
     */
    public function createFromCart(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $cartData = $this->cartService->getCartData();

            if (empty($cartData['items'])) {
                throw new \Exception('Cart is empty');
            }

            // Calculate totals
            $subtotal = $cartData['subtotal'];
            $tax = $cartData['tax'];
            $shippingCost = $data['shipping_cost'] ?? 0;
            $discount = 0;

            // Apply coupon if provided
            if (!empty($data['coupon_code'])) {
                $coupon = Coupon::where('code', $data['coupon_code'])->first();
                if ($coupon && $coupon->isValid()) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    $coupon->incrementUsage();
                }
            }

            $total = $subtotal + $tax + $shippingCost - $discount;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_email' => $data['email'],
                'customer_first_name' => $data['first_name'],
                'customer_last_name' => $data['last_name'],
                'customer_phone' => $data['phone'] ?? null,
                'shipping_address' => $data['address'],
                'shipping_city' => $data['city'],
                'shipping_state' => $data['state'],
                'shipping_zip_code' => $data['zip_code'],
                'shipping_country' => $data['country'] ?? 'US',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $data['payment_method'] ?? 'card',
                'notes' => $data['notes'] ?? null,
            ]);

            // Create order items and update stock
            foreach ($cartData['items'] as $item) {
                $product = Product::find($item['id']);

                if (!$product) {
                    throw new \Exception("Product {$item['name']} not found");
                }

                if (!$product->decrementStock($item['quantity'])) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }

            // Clear cart
            $this->cartService->clear();

            return $order;
        });
    }

    /**
     * Update order status
     */
    public function updateStatus(Order $order, string $status): Order
    {
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];

        if (!in_array($status, $validStatuses)) {
            throw new \Exception('Invalid order status');
        }

        $order->update(['status' => $status]);

        // Update timestamps based on status
        if ($status === 'shipped' && !$order->shipped_at) {
            $order->update(['shipped_at' => now()]);
        } elseif ($status === 'delivered' && !$order->delivered_at) {
            $order->update(['delivered_at' => now()]);
        }

        return $order;
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order): Order
    {
        if (!$order->canBeCancelled()) {
            throw new \Exception('This order cannot be cancelled');
        }

        DB::transaction(function () use ($order) {
            // Restore stock
            foreach ($order->items as $item) {
                $item->product->incrementStock($item->quantity);
            }

            $order->update(['status' => 'cancelled']);
        });

        return $order;
    }

    /**
     * Process refund
     */
    public function refund(Order $order): Order
    {
        if (!$order->isPaid()) {
            throw new \Exception('Cannot refund unpaid order');
        }

        DB::transaction(function () use ($order) {
            // Restore stock
            foreach ($order->items as $item) {
                $item->product->incrementStock($item->quantity);
            }

            $order->update([
                'status' => 'refunded',
                'payment_status' => 'refunded',
            ]);
        });

        return $order;
    }
}
