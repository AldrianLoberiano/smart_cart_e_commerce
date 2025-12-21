@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Orders
            </a>
        </div>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-8 border-b border-gray-200">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                        <p class="mt-1 text-sm text-gray-500">Placed on
                            {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                    <div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Items</h2>
                <div class="space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if ($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product_name }}" class="h-20 w-20 rounded object-cover">
                                @else
                                    <div class="h-20 w-20 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h3>
                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                    <span>Quantity: {{ $item->quantity }}</span>
                                    <span class="mx-2">•</span>
                                    <span>${{ number_format($item->price, 2) }} each</span>
                                </div>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="px-6 py-6 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="text-gray-900">${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="text-gray-900">${{ number_format($order->shipping, 2) }}</span>
                    </div>
                    @if ($order->discount > 0)
                        <div class="flex justify-between text-sm text-green-600">
                            <span>Discount</span>
                            <span>-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-base font-medium pt-2 border-t border-gray-200">
                        <span class="text-gray-900">Total</span>
                        <span class="text-gray-900">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping & Billing Info -->
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Shipping Address -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Shipping Address</h3>
                        <div class="text-sm text-gray-600">
                            <p>{{ $order->shipping_name }}</p>
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                            <p>{{ $order->shipping_country }}</p>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Billing Address</h3>
                        <div class="text-sm text-gray-600">
                            <p>{{ $order->billing_name }}</p>
                            <p>{{ $order->billing_address }}</p>
                            <p>{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zip }}</p>
                            <p>{{ $order->billing_country }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if ($order->status === 'pending' || $order->status === 'processing')
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <form action="{{ route('orders.cancel', $order) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to cancel this order?');">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                            Cancel Order
                        </button>
                    </form>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endsection
