@extends('layouts.app')

@section('title', $product->name . ' - SmartCart')

@section('content')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8 bg-white rounded-xl shadow-md px-6 py-4 border border-gray-100" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-3 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600 transition-colors font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Home
                    </a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-500 hover:text-primary-600 transition-colors font-medium">Products</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li class="text-gray-900 font-semibold">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 p-4">
                        <img src="{{ $product->primary_image ?? 'https://placehold.co/600x400?text=No+Image' }}"
                            alt="{{ $product->name }}" class="w-full h-auto rounded-xl">
                    </div>

                    @if (count($product->images ?? []) > 1)
                        <div class="grid grid-cols-4 gap-4 mt-4">
                            @foreach ($product->images as $image)
                                <img src="{{ $image }}" alt="{{ $product->name }}"
                                    class="bg-white rounded-xl shadow-md cursor-pointer hover:shadow-xl transition-all duration-200 transform hover:scale-105 border border-gray-100 p-2">
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6" x-data="productStockMonitor({{ $product->id }}, {{ $product->stock }}, {{ $product->low_stock_threshold }})">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <div class="mb-6">
                            <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                            <p class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-lg inline-block">SKU: <span class="font-semibold">{{ $product->sku }}</span></p>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
                            <span class="text-5xl font-bold bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">${{ number_format($product->price, 2) }}</span>
                            @if ($product->compare_price && $product->compare_price > $product->price)
                                <div class="flex flex-col">
                                    <span class="text-xl text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                                        </svg>
                                        Save {{ $product->discount_percentage }}%
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Rating -->
                        @if ($product->average_rating > 0)
                            <div class="flex items-center space-x-3 mb-6 pb-6 border-b border-gray-200">
                                <div class="flex items-center bg-gradient-to-r from-yellow-400 to-yellow-500 px-4 py-2 rounded-xl shadow-lg">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $product->average_rating ? 'text-white' : 'text-yellow-200' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-gray-600 font-medium">({{ $product->reviews->count() }} reviews)</span>
                            </div>
                        @endif

                        <!-- Stock Status with Progress Bar -->
                        <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Availability:
                                </span>
                                <span x-show="currentStock > 0 && !isLowStock" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    In Stock - <span x-text="currentStock"></span> available
                                </span>
                                <span x-show="currentStock > 0 && isLowStock" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Low Stock - Only <span x-text="currentStock"></span> left
                                </span>
                                <span x-show="currentStock <= 0" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Out of Stock
                                </span>
                            </div>

                            @if ($product->track_stock)
                                <!-- Stock Level Progress Bar -->
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="flex justify-between text-xs font-semibold text-gray-600 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                            </svg>
                                            Stock Level
                                        </span>
                                        <span><span x-text="currentStock"></span> / {{ $product->low_stock_threshold * 2 }} units</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-4 shadow-inner">
                                        <div class="h-4 rounded-full transition-all shadow-lg"
                                            :class="currentStock > 0 ? (isLowStock ? 'bg-gradient-to-r from-orange-400 to-orange-600' : 'bg-gradient-to-r from-green-400 to-emerald-600') : 'bg-gradient-to-r from-red-400 to-red-600'"
                                            :style="`width: ${stockPercentage}%`"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="prose prose-gray max-w-none mb-6 text-gray-700">
                            <p class="text-lg leading-relaxed">{{ $product->short_description }}</p>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="space-y-3 mb-6">
                            <label class="flex items-center text-sm font-semibold text-gray-700">
                                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                Quantity
                            </label>
                            <div class="flex items-center space-x-4 bg-gray-50 p-2 rounded-xl">
                                <button @click="decrement"
                                    class="w-14 h-14 rounded-xl bg-white hover:bg-gradient-to-r hover:from-primary-500 hover:to-primary-600 hover:text-white flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 border border-gray-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" x-model="quantity" @change="updateQuantity($event.target.value)"
                                    class="flex-1 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl py-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-500 transition-all"
                                    min="1" :max="max">
                                <button @click="increment"
                                    class="w-14 h-14 rounded-xl bg-white hover:bg-gradient-to-r hover:from-primary-500 hover:to-primary-600 hover:text-white flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 border border-gray-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Add to Cart -->
                        <div class="space-y-3">
                            <button @click="addToCart()" :disabled="currentStock <= 0" 
                                class="w-full py-5 rounded-xl text-lg font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center"
                                :class="currentStock <= 0 ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800'">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span x-show="currentStock > 0">Add to Cart</span>
                                <span x-show="currentStock <= 0">Out of Stock</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="mt-16 bg-white rounded-2xl shadow-lg p-8 border border-gray-100" x-data="{ activeTab: 'description' }">
                <div class="border-b border-gray-200 mb-8">
                    <nav class="-mb-px flex space-x-8">
                        <button @click="activeTab = 'description'"
                            :class="activeTab === 'description' ? 'border-primary-600 text-primary-600 bg-primary-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="border-b-4 py-4 px-6 text-lg font-semibold transition-all rounded-t-xl">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            Description
                        </button>
                        <button @click="activeTab = 'reviews'"
                            :class="activeTab === 'reviews' ? 'border-primary-600 text-primary-600 bg-primary-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="border-b-4 py-4 px-6 text-lg font-semibold transition-all rounded-t-xl">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Reviews 
                            <span class="ml-1 px-2 py-1 bg-primary-600 text-white rounded-full text-sm">{{ $product->reviews->count() }}</span>
                        </button>
                    </nav>
                </div>

                <div>
                    <div x-show="activeTab === 'description'" class="prose prose-lg max-w-none text-gray-700">
                        {!! $product->description !!}
                    </div>

                    <div x-show="activeTab === 'reviews'">
                        @if ($product->reviews->count() > 0)
                            <div class="space-y-6">
                                @foreach ($product->reviews as $review)
                                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow duration-200">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                                        {{ substr($review->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-lg text-gray-900">{{ $review->user->name }}</span>
                                                        @if ($review->is_verified)
                                                            <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-md">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Verified Purchase
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center mb-3">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                @if ($review->title)
                                                    <h4 class="font-bold text-lg text-gray-900 mb-2">{{ $review->title }}</h4>
                                                @endif
                                                <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                            </div>
                                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-lg font-medium">No reviews yet. Be the first to review this product!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <section class="mt-16">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">You May Also Like</h2>
                        <p class="text-gray-600 text-lg">Check out these related products</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <x-product-card :product="$relatedProduct" />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
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
