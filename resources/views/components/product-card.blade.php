@props(['product'])

<div class="card group cursor-pointer transition-transform hover:scale-105">
    <div class="relative overflow-hidden aspect-square">
        <img src="{{ $product->primary_image ?? 'https://placehold.co/600x400?text=No+Image' }}"
            alt="{{ $product->name }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">

        @if ($product->discount_percentage)
            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                -{{ $product->discount_percentage }}%
            </div>
        @endif

        @if ($product->is_featured)
            <div class="absolute top-2 left-2 bg-primary-600 text-white px-2 py-1 rounded-full text-xs font-bold">
                Featured
            </div>
        @endif

        <!-- Quick View Button -->
        <button @click.stop="$dispatch('open-quick-view', { productId: {{ $product->id }} })"
            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
            <span class="btn btn-primary">Quick View</span>
        </button>
    </div>

    <div class="p-4">
        <a href="{{ route('products.show', $product) }}" class="block space-y-2">
            <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition line-clamp-2">
                {{ $product->name }}
            </h3>

            @if ($product->average_rating > 0)
                <div class="flex items-center space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                    <span class="text-sm text-gray-600">({{ number_format($product->average_rating, 1) }})</span>
                </div>
            @endif

            <div class="flex items-center space-x-2">
                <span class="text-xl font-bold text-primary-600">${{ number_format($product->price, 2) }}</span>
                @if ($product->compare_price && $product->compare_price > $product->price)
                    <span
                        class="text-sm text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                @endif
            </div>

            <!-- Stock Information with Progress Bar -->
            <div class="space-y-2">
                @if ($product->isInStock())
                    @php
                        $stockPercentage = ($product->stock / max($product->low_stock_threshold * 2, 100)) * 100;
                        $stockPercentage = min($stockPercentage, 100);
                    @endphp
                    <div class="flex items-center justify-between text-sm">
                        @if ($product->isLowStock())
                            <span class="badge badge-warning">⚠️ Low Stock</span>
                            <span class="text-orange-600 font-semibold">{{ $product->stock }} left</span>
                        @else
                            <span class="badge badge-success">✓ In Stock</span>
                            <span class="text-green-600 font-semibold">{{ $product->stock }} available</span>
                        @endif
                    </div>
                    <!-- Stock Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all {{ $product->isLowStock() ? 'bg-orange-500' : 'bg-green-500' }}"
                            style="width: {{ $stockPercentage }}%"></div>
                    </div>
                @else
                    <div class="flex items-center justify-between text-sm">
                        <span class="badge badge-danger">✗ Out of Stock</span>
                        <span class="text-red-600 font-semibold">0 available</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full bg-red-500" style="width: 0%"></div>
                    </div>
                @endif
            </div>
        </a>

        <button
            @click="$dispatch('open-cart-modal', { product: {
                id: {{ $product->id }},
                name: {{ Js::from($product->name) }},
                price: {{ $product->price }},
                primary_image: {{ Js::from($product->primary_image) }},
                stock: {{ $product->stock }},
                isInStock: {{ $product->isInStock() ? 'true' : 'false' }},
                isLowStock: {{ $product->isLowStock() ? 'true' : 'false' }}
            } })"
            class="w-full mt-4 btn btn-primary" {{ !$product->isInStock() ? 'disabled' : '' }}>
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Add to Cart
        </button>
    </div>
</div>
