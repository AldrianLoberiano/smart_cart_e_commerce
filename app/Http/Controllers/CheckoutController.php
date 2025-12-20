<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService
    ) {}

    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = $this->cartService->getCartData();

        if (empty($cart['items'])) {
            return redirect()->route('home')
                ->with('error', 'Your cart is empty');
        }

        return view('checkout.index', [
            'cart' => $cart,
            'cartItemCount' => $cart['item_count'],
        ]);
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'nullable|string|max:2',
            'payment_method' => 'required|in:card,paypal',
            'coupon_code' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $order = $this->orderService->createFromCart($validated);

            // Process payment here (Stripe, PayPal, etc.)
            // For now, we'll mark it as pending

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => 'Order placed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
