<!-- Product Quick View Modal -->
<div x-data="productModal" x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <!-- Backdrop -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="closeModal"
        class="fixed inset-0 bg-black bg-opacity-50">
    </div>

    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.stop
            class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">

            <!-- Close Button -->
            <button @click="closeModal" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Loading State -->
            <template x-if="isLoading">
                <div class="flex items-center justify-center p-12">
                    <svg class="animate-spin h-12 w-12 text-primary-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </template>

            <!-- Product Content -->
            <template x-if="!isLoading && product">
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div>
                            <img :src="product.primary_image || 'https://placehold.co/600x400?text=No+Image'"
                                :alt="product.name" class="w-full h-auto rounded-lg">
                        </div>

                        <!-- Product Details -->
                        <div class="space-y-4">
                            <h2 class="text-3xl font-bold text-gray-900" x-text="product.name"></h2>

                            <div class="flex items-center space-x-2">
                                <span class="text-3xl font-bold text-primary-600"
                                    x-text="formatPrice(currentPrice)"></span>
                                <template x-if="product.compare_price && product.compare_price > product.price">
                                    <span class="text-lg text-gray-500 line-through"
                                        x-text="formatPrice(product.compare_price)"></span>
                                </template>
                            </div>

                            <!-- Stock Status -->
                            <div>
                                <template x-if="isInStock">
                                    <span class="badge badge-success">In Stock</span>
                                </template>
                                <template x-if="!isInStock">
                                    <span class="badge badge-danger">Out of Stock</span>
                                </template>
                            </div>

                            <!-- Description -->
                            <div class="prose prose-sm" x-html="product.short_description || product.description"></div>

                            <!-- Quantity Selector -->
                            <div x-data="quantitySelector(1, 1, 99)" class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <div class="flex items-center space-x-3">
                                    <button @click="decrement"
                                        class="w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input type="number" x-model="quantity"
                                        @change="updateQuantity($event.target.value)"
                                        class="w-20 text-center border border-gray-300 rounded-lg py-2" min="1"
                                        max="99">
                                    <button @click="increment"
                                        class="w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="space-y-2 pt-4">
                                <button @click="addToCart" :disabled="!isInStock"
                                    :class="{ 'opacity-50 cursor-not-allowed': !isInStock }"
                                    class="w-full btn btn-primary">
                                    Add to Cart
                                </button>
                                <a :href="`/products/${product.slug}`"
                                    class="block w-full btn btn-secondary text-center">
                                    View Full Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Aldrian Loberiano\Documents\GitHub\smart_cart_e_commerce\resources\views/components/product-modal.blade.php ENDPATH**/ ?>