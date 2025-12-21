@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Success Header -->
            <div class="bg-green-50 px-6 py-8 text-center border-b border-green-100">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Order Confirmed!</h1>
                <p class="mt-2 text-gray-600">Thank you for your purchase</p>
            </div>

            <!-- Order Info -->
            <div class="px-6 py-6 border-b border-gray-200">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Order Number</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">#{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        A confirmation email has been sent to <span class="font-medium">{{ $order->user->email }}</span>
                    </p>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if ($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product_name }}" class="h-16 w-16 rounded object-cover">
                                @else
                                    <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
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
            </div>

            <!-- Shipping Info -->
            <div class="px-6 py-6 border-b border-gray-200">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Shipping Address</h3>
                <div class="text-sm text-gray-600">
                    <p>{{ $order->shipping_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                    <p>{{ $order->shipping_country }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-6 bg-gray-50">
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('orders.show', $order) }}"
                        class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        View Order Details
                    </a>
                    <a href="{{ route('home') }}"
                        class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
