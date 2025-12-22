<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Real-Time Stock Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-8" x-data="stockMonitor">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">🔴 Real-Time Stock Monitoring Test</h1>
            <p class="text-gray-600 mb-6">
                Stock levels are checked every 3 seconds. Try purchasing products or running the test below to see
                real-time updates!
            </p>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-900 mb-2">How to test:</h3>
                <ol class="list-decimal list-inside space-y-1 text-blue-800">
                    <li>Open this page in one browser window</li>
                    <li>Open the products page in another window</li>
                    <li>Click "Simulate Purchase" below to decrease stock</li>
                    <li>Watch both windows update automatically!</li>
                </ol>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach (\App\Models\Product::where('track_stock', true)->take(3)->get() as $product)
                    <div class="border border-gray-200 rounded-lg p-4" data-product-id="{{ $product->id }}"
                        data-product-stock="{{ $product->stock }}">
                        <img src="{{ $product->primary_image ?? 'https://placehold.co/300x200?text=Product' }}"
                            alt="{{ $product->name }}" class="w-full h-40 object-cover rounded-lg mb-3">
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-2xl font-bold text-primary-600 mb-2">${{ number_format($product->price, 2) }}</p>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span
                                    class="stock-badge inline-block px-3 py-1 rounded text-sm font-semibold
                                {{ $product->stock === 0
                                    ? 'bg-red-100 text-red-800'
                                    : ($product->isLowStock()
                                        ? 'bg-orange-100 text-orange-800'
                                        : 'bg-green-100 text-green-800') }}">
                                    {{ $product->stock === 0 ? '✗ Out of Stock' : ($product->isLowStock() ? '⚠️ Low Stock' : '✓ In Stock') }}
                                </span>
                                <span class="font-bold text-lg">
                                    <span data-stock-display="{{ $product->id }}">{{ $product->stock }}</span>
                                </span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all
                                {{ $product->stock === 0 ? 'bg-red-500' : ($product->isLowStock() ? 'bg-orange-500' : 'bg-green-500') }}"
                                    style="width: {{ min(($product->stock / 20) * 100, 100) }}%">
                                </div>
                            </div>

                            <button onclick="simulatePurchase({{ $product->id }}, 2)"
                                class="w-full add-to-cart-btn bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-700 transition
                                {{ $product->stock === 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $product->stock === 0 ? 'disabled' : '' }}>
                                Simulate Purchase (-2)
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-900 mb-2">✅ Features:</h3>
                <ul class="list-disc list-inside space-y-1 text-green-800">
                    <li>Stock levels update every 3 seconds automatically</li>
                    <li>Visual indicators change based on stock level (green → orange → red)</li>
                    <li>Progress bars show stock availability</li>
                    <li>Add to cart buttons disable when out of stock</li>
                    <li>Notifications appear for significant stock changes</li>
                    <li>Works across multiple browser windows/tabs simultaneously</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        async function simulatePurchase(productId, quantity) {
            try {
                const response = await axios.post('/api/test/simulate-purchase', {
                    product_id: productId,
                    quantity: quantity
                });

                if (response.data.success) {
                    window.showNotification(`Simulated purchase of ${quantity} items`, 'success');
                } else {
                    window.showNotification(response.data.message || 'Purchase simulation failed', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                window.showNotification('Error simulating purchase', 'error');
            }
        }
    </script>
</body>

</html>
