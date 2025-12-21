<!-- Add to Cart Modal -->
<div x-data="addToCartModal" x-show="isOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
    @open-cart-modal.window="openModal($event.detail)">

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
            class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full">

            <!-- Close Button -->
            <button @click="closeModal"
                class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Body -->
            <div class="p-6" x-show="product">
                <!-- Product Info -->
                <div class="flex items-start space-x-4 mb-6">
                    <img :src="product?.primary_image || 'https://placehold.co/100x100?text=No+Image'"
                        :alt="product?.name" class="w-20 h-20 rounded-lg object-cover">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-1" x-text="product?.name"></h3>
                        <p class="text-2xl font-bold text-primary-600" x-text="'$' + (product?.price || 0).toFixed(2)">
                        </p>
                    </div>
                </div>

                <!-- Stock Status -->
                <div class="mb-6">
                    <template x-if="product?.isInStock">
                        <div class="flex items-center space-x-2">
                            <template x-if="product?.isLowStock">
                                <span class="badge badge-warning">⚠️ Only <span x-text="product?.stock"></span>
                                    left</span>
                            </template>
                            <template x-if="!product?.isLowStock">
                                <span class="badge badge-success">✓ <span x-text="product?.stock"></span>
                                    available</span>
                            </template>
                        </div>
                    </template>
                    <template x-if="!product?.isInStock">
                        <span class="badge badge-danger">✗ Out of Stock</span>
                    </template>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Quantity</label>
                    <div class="flex items-center justify-center space-x-4">
                        <button @click="decrementQuantity" :disabled="quantity <= 1"
                            :class="{ 'opacity-50 cursor-not-allowed': quantity <= 1 }"
                            class="w-12 h-12 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>

                        <div class="flex flex-col items-center">
                            <input type="number" x-model.number="quantity" @input="validateQuantity" min="1"
                                :max="product?.stock || 1"
                                class="w-20 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg py-3 focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                            <span class="text-xs text-gray-500 mt-1">Quantity</span>
                        </div>

                        <button @click="incrementQuantity" :disabled="quantity >= (product?.stock || 1)"
                            :class="{ 'opacity-50 cursor-not-allowed': quantity >= (product?.stock || 1) }"
                            class="w-12 h-12 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Total Price -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Total:</span>
                        <span class="text-3xl font-bold text-primary-600" x-text="'$' + totalPrice.toFixed(2)"></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button @click="addToCart" :disabled="!product?.isInStock"
                        :class="{ 'opacity-50 cursor-not-allowed': !product?.isInStock }"
                        class="w-full btn btn-primary text-lg py-4">
                        <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Add <span x-text="quantity"></span> to Cart
                    </button>
                    <button @click="closeModal" class="w-full btn btn-secondary">
                        Continue Shopping
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('addToCartModal', () => ({
            isOpen: false,
            product: null,
            quantity: 1,

            get totalPrice() {
                return (this.product?.price || 0) * this.quantity;
            },

            openModal(detail) {
                this.product = detail.product;
                this.quantity = 1;
                this.isOpen = true;
                document.body.style.overflow = 'hidden';
            },

            closeModal() {
                this.isOpen = false;
                document.body.style.overflow = '';
            },

            incrementQuantity() {
                if (this.quantity < (this.product?.stock || 1)) {
                    this.quantity++;
                }
            },

            decrementQuantity() {
                if (this.quantity > 1) {
                    this.quantity--;
                }
            },

            validateQuantity() {
                const max = this.product?.stock || 1;
                if (this.quantity < 1) {
                    this.quantity = 1;
                } else if (this.quantity > max) {
                    this.quantity = max;
                }
            },

            async addToCart() {
                if (!this.product?.isInStock) return;

                try {
                    console.log('Adding to cart:', {
                        product_id: this.product.id,
                        quantity: this.quantity
                    });

                    const response = await fetch('/api/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: this.product.id,
                            quantity: this.quantity
                        })
                    });

                    const data = await response.json();
                    console.log('Response:', response.status, data);

                    if (response.ok) {
                        // Update cart count
                        window.dispatchEvent(new CustomEvent('cart-updated', {
                            detail: {
                                count: data.item_count
                            }
                        }));

                        // Close modal
                        this.closeModal();

                        // Show success notification
                        if (window.Alpine && window.Alpine.store('toast')) {
                            window.Alpine.store('toast').show(
                                `${this.quantity} item(s) added to cart!`, 'success');
                        } else {
                            alert(`${this.quantity} item(s) added to cart!`);
                        }
                    } else {
                        // Handle error response
                        const errorMsg = data.error || data.message || JSON.stringify(data);
                        console.error('Error response:', data);
                        alert(`Error: ${errorMsg}`);
                    }
                } catch (error) {
                    console.error('Error adding to cart:', error);
                    alert('Failed to add to cart. Please try again.');
                }
            }
        }));
    });
</script>
<?php /**PATH C:\Users\Aldrian Loberiano\Documents\GitHub\smart_cart_e_commerce\resources\views/components/add-to-cart-modal.blade.php ENDPATH**/ ?>