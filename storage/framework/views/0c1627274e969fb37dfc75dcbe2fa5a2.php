

<?php $__env->startSection('title', 'Shopping Cart - SmartCart'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Empty Cart -->
        <template x-if="items.length === 0">
            <div class="text-center py-16">
                <svg class="mx-auto h-32 w-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="mt-6 text-2xl font-semibold text-gray-900">Your cart is empty</h2>
                <p class="mt-2 text-gray-600">Add some products to get started!</p>
                <a href="<?php echo e(route('products.index')); ?>" class="mt-6 inline-block btn btn-primary">
                    Continue Shopping
                </a>
            </div>
        </template>

        <!-- Cart Items -->
        <template x-if="items.length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Items List -->
                <div class="lg:col-span-2 space-y-4">
                    <template x-for="item in items" :key="item.id">
                        <div class="card p-6">
                            <div class="flex items-center space-x-6">
                                <!-- Product Image -->
                                <img :src="item.image || 'https://placehold.co/600x400?text=No+Image'"
                                    :alt="item.name" class="w-24 h-24 object-cover rounded-lg">

                                <!-- Product Details -->
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <a :href="`/products/${item.slug}`"
                                            class="hover:text-primary-600" x-text="item.name">
                                        </a>
                                    </h3>
                                    <p class="text-primary-600 font-bold text-xl mt-1" x-text="formatPrice(item.price)"></p>

                                    <!-- Quantity Selector -->
                                    <div class="flex items-center space-x-4 mt-4">
                                        <div class="flex items-center space-x-2">
                                            <label class="text-sm text-gray-600">Quantity:</label>
                                            <div class="flex items-center border rounded-lg">
                                                <button @click="updateQuantity(`product_${item.id}`, item.quantity - 1)"
                                                    class="px-3 py-1 hover:bg-gray-100 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <input type="number" :value="item.quantity"
                                                    @change="updateQuantity(`product_${item.id}`, parseInt($event.target.value))"
                                                    min="1" max="99"
                                                    class="w-16 text-center border-x py-1 focus:outline-none">
                                                <button @click="updateQuantity(`product_${item.id}`, item.quantity + 1)"
                                                    class="px-3 py-1 hover:bg-gray-100 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Remove Button -->
                                        <button @click="if(confirm('Remove this item from cart?')) removeItem(`product_${item.id}`)"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium transition">
                                            Remove
                                        </button>
                                    </div>
                                </div>

                                <!-- Item Total -->
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900" x-text="formatPrice(item.price * item.quantity)"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Clear Cart -->
                    <div class="mt-4">
                        <button @click="clearCart()" class="text-red-600 hover:text-red-800 text-sm font-medium">
                            Clear Cart
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="card p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal (<span x-text="itemCount"></span> items):</span>
                                <span x-text="formatPrice(subtotal)"></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Tax (8%):</span>
                                <span x-text="formatPrice(tax)"></span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-xl font-bold text-gray-900">
                                    <span>Total:</span>
                                    <span x-text="formatPrice(total)"></span>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo e(route('checkout.index')); ?>" class="block w-full btn btn-primary text-center mb-3">
                            Proceed to Checkout
                        </a>

                        <a href="<?php echo e(route('products.index')); ?>" class="block w-full btn btn-secondary text-center">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\SmartCart – Modern E-Commerce Web Application\smart_cart\resources\views/cart/index.blade.php ENDPATH**/ ?>