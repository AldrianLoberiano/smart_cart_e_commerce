<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Diagnostic Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6">🔍 Real-Time Stock System Diagnostic</h1>

        <div class="space-y-6">
            <!-- Test 1: Alpine.js -->
            <div class="border-l-4 border-blue-500 pl-4">
                <h2 class="text-xl font-semibold mb-2">Test 1: Alpine.js Loaded</h2>
                <div x-data="{ test: 'Alpine.js is working!' }">
                    <p class="text-green-600 font-semibold" x-text="test"></p>
                    <p id="alpine-test" class="text-red-600">If you see this, Alpine.js failed</p>
                </div>
            </div>

            <!-- Test 2: Axios -->
            <div class="border-l-4 border-green-500 pl-4">
                <h2 class="text-xl font-semibold mb-2">Test 2: Axios Available</h2>
                <p id="axios-test" class="font-semibold">Checking...</p>
            </div>

            <!-- Test 3: Stock Monitor Component -->
            <div class="border-l-4 border-purple-500 pl-4">
                <h2 class="text-xl font-semibold mb-2">Test 3: Stock Monitor Component</h2>
                <div x-data="stockMonitor">
                    <p class="text-green-600 font-semibold">Stock monitor initialized</p>
                    <p class="text-sm text-gray-600">Products tracked: <span
                            x-text="Object.keys(products).length"></span></p>
                </div>
            </div>

            <!-- Test 4: API Endpoint -->
            <div class="border-l-4 border-orange-500 pl-4">
                <h2 class="text-xl font-semibold mb-2">Test 4: API Endpoint</h2>
                <button onclick="testAPI()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Test API Call
                </button>
                <pre id="api-result" class="mt-2 p-4 bg-gray-100 rounded text-sm overflow-auto"></pre>
            </div>

            <!-- Test 5: Product Detection -->
            <div class="border-l-4 border-red-500 pl-4" x-data="stockMonitor">
                <h2 class="text-xl font-semibold mb-2">Test 5: Product Detection</h2>
                <div class="space-y-2">
                    @foreach (\App\Models\Product::take(3)->get() as $product)
                        <div class="p-3 bg-gray-50 rounded" data-product-id="{{ $product->id }}"
                            data-product-stock="{{ $product->stock }}">
                            <p class="font-semibold">{{ $product->name }}</p>
                            <p class="text-sm">
                                Stock: <span data-stock-display="{{ $product->id }}">{{ $product->stock }}</span>
                                <span class="text-green-600" x-show="products[{{ $product->id }}] !== undefined">✓
                                    Tracked</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Console Logs -->
            <div class="border-l-4 border-gray-500 pl-4">
                <h2 class="text-xl font-semibold mb-2">Test 6: Console Logs</h2>
                <p class="text-sm text-gray-600">Check browser console (F12) for errors</p>
                <button onclick="logInfo()" class="mt-2 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Log System Info
                </button>
            </div>
        </div>

        <div class="mt-8 p-4 bg-blue-50 rounded">
            <h3 class="font-semibold text-blue-900 mb-2">What to check:</h3>
            <ul class="list-disc list-inside space-y-1 text-blue-800 text-sm">
                <li>All tests should show green/success messages</li>
                <li>Open browser console (F12) and check for errors</li>
                <li>API test should return product data</li>
                <li>Products should show "✓ Tracked" next to stock numbers</li>
            </ul>
        </div>
    </div>

    <script>
        // Test Axios
        document.addEventListener('DOMContentLoaded', () => {
            const axiosTest = document.getElementById('axios-test');
            if (typeof axios !== 'undefined') {
                axiosTest.textContent = '✓ Axios is loaded and ready';
                axiosTest.className = 'font-semibold text-green-600';
            } else {
                axiosTest.textContent = '✗ Axios not found';
                axiosTest.className = 'font-semibold text-red-600';
            }
        });

        async function testAPI() {
            const result = document.getElementById('api-result');
            result.textContent = 'Testing...';

            try {
                const response = await axios.post('/api/stock/check', {
                    product_ids: [1, 2, 3]
                });
                result.textContent = JSON.stringify(response.data, null, 2);
                result.className = 'mt-2 p-4 bg-green-50 rounded text-sm overflow-auto';
            } catch (error) {
                result.textContent = 'Error: ' + error.message;
                result.className = 'mt-2 p-4 bg-red-50 rounded text-sm overflow-auto';
                console.error('API Error:', error);
            }
        }

        function logInfo() {
            console.log('=== System Diagnostic ===');
            console.log('Alpine.js:', typeof Alpine !== 'undefined' ? 'Loaded' : 'NOT FOUND');
            console.log('Axios:', typeof axios !== 'undefined' ? 'Loaded' : 'NOT FOUND');
            console.log('Window.formatPrice:', typeof window.formatPrice !== 'undefined' ? 'Loaded' : 'NOT FOUND');
            console.log('Window.showNotification:', typeof window.showNotification !== 'undefined' ? 'Loaded' :
            'NOT FOUND');
            console.log('Products on page:', document.querySelectorAll('[data-product-id]').length);
            console.log('======================');
            alert('Check console for system info');
        }
    </script>
</body>

</html>
