@extends('layouts.app')

@section('title', $product->name . ' - SmartCart')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">Products</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-900 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div>
                <div class="card overflow-hidden">
                    <img src="{{ $product->primary_image ?? 'https://placehold.co/600x400?text=No+Image' }}"
                        alt="{{ $product->name }}" class="w-full h-auto">
                </div>

                @if (count($product->images ?? []) > 1)
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        @foreach ($product->images as $image)
                            <img src="{{ $image }}" alt="{{ $product->name }}"
                                class="card cursor-pointer hover:opacity-75 transition">
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6" x-data="productStockMonitor({{ $product->id }}, {{ $product->stock }}, {{ $product->low_stock_threshold }})">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                    <p class="text-sm text-gray-600">SKU: {{ $product->sku }}</p>
                </div>

                <!-- Price -->
                <div class="flex items-center space-x-3">
                    <span class="text-4xl font-bold text-primary-600">${{ number_format($product->price, 2) }}</span>
                    @if ($product->compare_price && $product->compare_price > $product->price)
                        <span
                            class="text-2xl text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                        <span class="badge badge-danger">Save {{ $product->discount_percentage }}%</span>
                    @endif
                </div>

                <!-- Rating -->
                @if ($product->average_rating > 0)
                    <div class="flex items-center space-x-2">
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-gray-600">({{ $product->reviews->count() }} reviews)</span>
                    </div>
                @endif

                <!-- Stock Status with Progress Bar -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Availability:</span>
                        <span x-show="currentStock > 0 && !isLowStock" class="badge badge-success text-base">
                            ✓ In Stock - <span x-text="currentStock"></span> available
                        </span>
                        <span x-show="currentStock > 0 && isLowStock" class="badge badge-warning text-base">
                            ⚠️ Low Stock - Only <span x-text="currentStock"></span> left
                        </span>
                        <span x-show="currentStock <= 0" class="badge badge-danger text-base">
                            ✗ Out of Stock
                        </span>
                    </div>

                    @if ($product->track_stock)
                        <!-- Stock Level Progress Bar -->
                        <div>
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Stock Level</span>
                                <span><span x-text="currentStock"></span> / {{ $product->low_stock_threshold * 2 }}
                                    units</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all"
                                    :class="currentStock > 0 ? (isLowStock ? 'bg-orange-500' : 'bg-green-500') : 'bg-red-500'"
                                    :style="`width: ${stockPercentage}%`"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="prose prose-gray max-w-none">
                    <p>{{ $product->short_description }}</p>
                </div>

                <!-- Quantity Selector -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <div class="flex items-center space-x-4">
                        <button @click="decrement"
                            class="w-12 h-12 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <input type="number" x-model="quantity" @change="updateQuantity($event.target.value)"
                            class="w-24 text-center text-xl font-semibold border border-gray-300 rounded-lg py-3"
                            min="1" :max="max">
                        <button @click="increment"
                            class="w-12 h-12 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Add to Cart -->
                <div class="space-y-3 pt-4">
                    <button @click="addToCart()" :disabled="currentStock <= 0" class="w-full btn btn-primary py-4 text-lg"
                        :class="{ 'opacity-50 cursor-not-allowed': currentStock <= 0 }">
                        <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="currentStock > 0">Add to Cart</span>
                        <span x-show="currentStock <= 0">Out of Stock</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="mt-16" x-data="{ activeTab: 'description' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button @click="activeTab = 'description'"
                        :class="{ 'border-primary-600 text-primary-600': activeTab === 'description' }"
                        class="border-b-2 border-transparent py-4 px-1 text-gray-500 hover:text-gray-700 font-medium">
                        Description
                    </button>
                    <button @click="activeTab = 'reviews'"
                        :class="{ 'border-primary-600 text-primary-600': activeTab === 'reviews' }"
                        class="border-b-2 border-transparent py-4 px-1 text-gray-500 hover:text-gray-700 font-medium">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                </nav>
            </div>

            <div class="mt-8">
                <div x-show="activeTab === 'description'" class="prose max-w-none">
                    {!! $product->description !!}
                </div>

                <div x-show="activeTab === 'reviews'">
                    @if ($product->reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach ($product->reviews as $review)
                                <div class="card p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2">
                                                <span class="font-semibold">{{ $review->user->name }}</span>
                                                @if ($review->is_verified)
                                                    <span class="badge badge-success">Verified Purchase</span>
                                                @endif
                                            </div>
                                            <div class="flex mt-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            @if ($review->title)
                                                <h4 class="font-semibold mt-2">{{ $review->title }}</h4>
                                            @endif
                                            <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                                        </div>
                                        <span
                                            class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <section class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function productStockMonitor(productId, initialStock, lowStockThreshold) {
            return {
                productId: productId,
                currentStock: initialStock,
                lowStockThreshold: lowStockThreshold,
                maxStock: lowStockThreshold * 2,
                quantity: 1,
                min: 1,

                init() {
                    // Update stock every 5 seconds
                    setInterval(() => {
                        this.fetchCurrentStock();
                    }, 5000);
                },

                get isLowStock() {
                    return this.currentStock <= this.lowStockThreshold && this.currentStock > 0;
                },

                get stockPercentage() {
                    return Math.min((this.currentStock / Math.max(this.maxStock, 100)) * 100, 100);
                },

                get max() {
                    return Math.max(this.currentStock, 1);
                },

                async fetchCurrentStock() {
                    try {
                        const response = await fetch(`/api/product-stock/${this.productId}`);
                        const data = await response.json();

                        if (data.stock !== this.currentStock) {
                            this.currentStock = data.stock;

                            // Adjust quantity if it exceeds available stock
                            if (this.quantity > this.currentStock) {
                                this.quantity = Math.max(this.currentStock, 1);
                            }
                        }
                    } catch (error) {
                        console.error('Error fetching stock:', error);
                    }
                },

                increment() {
                    if (this.quantity < this.max) {
                        this.quantity++;
                    }
                },

                decrement() {
                    if (this.quantity > this.min) {
                        this.quantity--;
                    }
                },

                async addToCart() {
                    if (this.currentStock <= 0) {
                        window.showNotification('Product is out of stock', 'error');
                        return;
                    }

                    try {
                        const response = await fetch('/api/cart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                product_id: this.productId,
                                quantity: this.quantity
                            })
                        });

                        const data = await response.json();

                        if (response.ok) {
                            window.showNotification('Added to cart successfully!', 'success');

                            // Update cart count
                            if (window.updateCartCount) {
                                window.updateCartCount(data.item_count);
                            }

                            // Immediately refresh stock after adding to cart
                            this.fetchCurrentStock();
                        } else {
                            window.showNotification(data.error || 'Failed to add to cart', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        window.showNotification('An error occurred', 'error');
                    }
                }
            };
        }
    </script>
@endpush
