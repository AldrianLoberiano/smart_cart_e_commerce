<!-- Cart Sidebar -->
<div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="closeCart"
    class="fixed inset-0 bg-black bg-opacity-50 z-50" style="display: none;">
</div>

<div x-show="isOpen" x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed right-0 top-0 h-full w-full max-w-md bg-white shadow-xl z-50 flex flex-col" style="display: none;">

    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b">
        <h2 class="text-2xl font-bold text-gray-900">Shopping Cart</h2>
        <button @click="closeCart" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Cart Items -->
    <div class="flex-1 overflow-y-auto p-6">
        <template x-if="items.length === 0">
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="mt-4 text-gray-500">Your cart is empty</p>
                <a href="<?php echo e(route('products.index')); ?>" class="mt-4 inline-block btn btn-primary">
                    Continue Shopping
                </a>
            </div>
        </template>

        <template x-if="items.length > 0">
            <div class="space-y-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <img :src="item.image || 'https://placehold.co/600x400?text=No+Image'" :alt="item.name"
                            class="w-20 h-20 object-cover rounded">

                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900" x-text="item.name"></h3>
                            <p class="text-primary-600 font-semibold" x-text="formatPrice(item.price)"></p>

                            <!-- Quantity Selector -->
                            <div class="flex items-center mt-2 space-x-2">
                                <button @click="updateQuantity(`product_${item.id}`, item.quantity - 1)"
                                    class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4" />
                                    </svg>
                                </button>
                                <span class="w-12 text-center font-semibold" x-text="item.quantity"></span>
                                <button @click="updateQuantity(`product_${item.id}`, item.quantity + 1)"
                                    class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button @click="removeItem(`product_${item.id}`)" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <!-- Footer -->
    <div x-show="items.length > 0" class="border-t p-6 space-y-4">
        <!-- Totals -->
        <div class="space-y-2">
            <div class="flex justify-between text-gray-600">
                <span>Subtotal:</span>
                <span x-text="formatPrice(subtotal)"></span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Tax (8%):</span>
                <span x-text="formatPrice(tax)"></span>
            </div>
            <div class="flex justify-between text-xl font-bold text-gray-900">
                <span>Total:</span>
                <span x-text="formatPrice(total)"></span>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-2">
            <a href="<?php echo e(route('checkout.index')); ?>" class="block w-full btn btn-primary text-center">
                Proceed to Checkout
            </a>
            <button @click="closeCart" class="block w-full btn btn-secondary text-center">
                Continue Shopping
            </button>
        </div>
    </div>
</div>
<?php /**PATH C:\smart_cart_e_commerce\resources\views/components/cart-sidebar.blade.php ENDPATH**/ ?>