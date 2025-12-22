<!-- Cart Sidebar Overlay -->
<div x-show="isOpen" 
    x-transition:enter="transition ease-out duration-300" 
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" 
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" 
    x-transition:leave-end="opacity-0" 
    @click="closeCart"
    class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm z-50" 
    style="display: none;">
</div>

<!-- Cart Sidebar Panel -->
<div x-show="isOpen" 
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="translate-x-full" 
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200 transform" 
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl z-50 flex flex-col" 
    style="display: none;">

    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-6 text-white shadow-lg">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-2xl font-bold flex items-center">
                <svg class="w-7 h-7 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Shopping Cart
            </h2>
            <button @click="closeCart" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div x-show="items.length > 0" class="flex items-center space-x-2 text-primary-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span x-text="itemCount + ' item' + (itemCount > 1 ? 's' : '') + ' in cart'"></span>
        </div>
    </div>

    <!-- Cart Items -->
    <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
        <!-- Empty State -->
        <template x-if="items.length === 0">
            <div class="flex flex-col items-center justify-center h-full text-center py-12">
                <div class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-6">Discover amazing products!</p>
                <a href="{{ route('products.index') }}" @click="closeCart" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Start Shopping
                </a>
            </div>
        </template>

        <!-- Items List -->
        <template x-if="items.length > 0">
            <div class="space-y-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <!-- Product Image -->
                            <div class="relative flex-shrink-0">
                                <img :src="item.image || 'https://placehold.co/600x400?text=No+Image'" 
                                    :alt="item.name"
                                    class="w-24 h-24 object-cover rounded-lg shadow-sm group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute -top-2 -right-2 w-7 h-7 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-lg" x-text="item.quantity"></div>
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-900 mb-1 line-clamp-2" x-text="item.name"></h3>
                                <p class="text-xl font-bold text-primary-600 mb-3" x-text="formatPrice(item.price)"></p>

                                <!-- Quantity Controls -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center bg-gray-100 rounded-lg overflow-hidden">
                                        <button @click="updateQuantity(`product_${item.id}`, item.quantity - 1)"
                                            class="w-9 h-9 flex items-center justify-center hover:bg-primary-100 hover:text-primary-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="w-10 text-center font-bold text-gray-900" x-text="item.quantity"></span>
                                        <button @click="updateQuantity(`product_${item.id}`, item.quantity + 1)"
                                            class="w-9 h-9 flex items-center justify-center hover:bg-primary-100 hover:text-primary-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Remove Button -->
                                    <button @click="if(confirm('Remove this item?')) removeItem(`product_${item.id}`)" 
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors group">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Item Subtotal -->
                        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-sm text-gray-600">Subtotal:</span>
                            <span class="text-lg font-bold text-gray-900" x-text="formatPrice(item.price * item.quantity)"></span>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <!-- Footer -->
    <div x-show="items.length > 0" class="border-t-2 border-gray-200 bg-white">
        <!-- Totals -->
        <div class="p-6 space-y-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-gray-700">Subtotal:</span>
                <span class="font-semibold text-gray-900" x-text="formatPrice(subtotal)"></span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-gray-700">Tax (8%):</span>
                <span class="font-semibold text-gray-900" x-text="formatPrice(tax)"></span>
            </div>
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-primary-50 to-primary-100 rounded-xl border-2 border-primary-200">
                <div>
                    <span class="text-sm text-primary-700 font-medium block">Total</span>
                    <span class="text-xs text-primary-600">Including taxes</span>
                </div>
                <span class="text-2xl font-bold text-primary-700" x-text="formatPrice(total)"></span>
            </div>
        </div>

        <!-- Actions -->
        <div class="px-6 pb-6 space-y-3">
            <a href="{{ route('checkout.index') }}" class="block w-full py-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold text-center rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Proceed to Checkout
                </span>
            </a>
            <button @click="closeCart" class="block w-full py-3 bg-white hover:bg-gray-50 text-gray-700 font-medium text-center rounded-xl border-2 border-gray-200 transition-all duration-200">
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Continue Shopping
                </span>
            </button>
        </div>
    </div>
</div>
