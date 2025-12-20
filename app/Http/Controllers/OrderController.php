<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private CartService $cartService
    ) {}

    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders,
            'cartItemCount' => $this->cartService->getItemCount(),
        ]);
    }

    /**
     * Display single order
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', [
            'order' => $order,
            'cartItemCount' => $this->cartService->getItemCount(),
        ]);
    }

    /**
     * Order confirmation page
     */
    public function confirmation(Order $order)
    {
        return view('orders.confirmation', [
            'order' => $order,
            'cartItemCount' => 0,
        ]);
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $this->orderService->cancel($order);

            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Order cancelled successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
