

<?php $__env->startSection('title', 'Checkout - SmartCart'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="checkout">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Step 1: Shipping Information -->
                <div class="card p-6" x-show="step === 1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Shipping Information</h2>

                    <form @submit.prevent="proceedToPayment" class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                                <input type="text" x-model="shippingInfo.firstName"
                                    :class="{ 'border-red-500': errors.firstName }" class="input" required>
                                <p x-show="errors.firstName" class="text-red-500 text-sm mt-1" x-text="errors.firstName">
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                                <input type="text" x-model="shippingInfo.lastName"
                                    :class="{ 'border-red-500': errors.lastName }" class="input" required>
                                <p x-show="errors.lastName" class="text-red-500 text-sm mt-1" x-text="errors.lastName"></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                            <input type="email" x-model="shippingInfo.email" :class="{ 'border-red-500': errors.email }"
                                class="input" required>
                            <p x-show="errors.email" class="text-red-500 text-sm mt-1" x-text="errors.email"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" x-model="shippingInfo.phone" class="input">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address*</label>
                            <input type="text" x-model="shippingInfo.address"
                                :class="{ 'border-red-500': errors.address }" class="input" required>
                            <p x-show="errors.address" class="text-red-500 text-sm mt-1" x-text="errors.address"></p>
                        </div>

                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City*</label>
                                <input type="text" x-model="shippingInfo.city" :class="{ 'border-red-500': errors.city }"
                                    class="input" required>
                                <p x-show="errors.city" class="text-red-500 text-sm mt-1" x-text="errors.city"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">State*</label>
                                <input type="text" x-model="shippingInfo.state"
                                    :class="{ 'border-red-500': errors.state }" class="input" required>
                                <p x-show="errors.state" class="text-red-500 text-sm mt-1" x-text="errors.state"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ZIP Code*</label>
                                <input type="text" x-model="shippingInfo.zipCode"
                                    :class="{ 'border-red-500': errors.zipCode }" class="input" required>
                                <p x-show="errors.zipCode" class="text-red-500 text-sm mt-1" x-text="errors.zipCode"></p>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn btn-primary">
                            Continue to Payment
                        </button>
                    </form>
                </div>

                <!-- Step 2: Payment -->
                <div class="card p-6" x-show="step === 2">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Payment Method</h2>
                        <button @click="backToShipping" class="text-primary-600 hover:text-primary-700">
                            ← Back to Shipping
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Payment Method Selection -->
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50"
                                :class="{ 'border-primary-600 bg-primary-50': paymentMethod === 'card' }">
                                <input type="radio" x-model="paymentMethod" value="card"
                                    class="text-primary-600 focus:ring-primary-500">
                                <span class="ml-3 flex-1">
                                    <span class="block font-medium">Credit/Debit Card</span>
                                    <span class="text-sm text-gray-500">Visa, Mastercard, American Express</span>
                                </span>
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50"
                                :class="{ 'border-primary-600 bg-primary-50': paymentMethod === 'paypal' }">
                                <input type="radio" x-model="paymentMethod" value="paypal"
                                    class="text-primary-600 focus:ring-primary-500">
                                <span class="ml-3 flex-1">
                                    <span class="block font-medium">PayPal</span>
                                    <span class="text-sm text-gray-500">Pay with your PayPal account</span>
                                </span>
                            </label>
                        </div>

                        <!-- Card Details (shown only for card payment) -->
                        <div x-show="paymentMethod === 'card'" class="space-y-4 pt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                <input type="text" placeholder="1234 5678 9012 3456" class="input">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                    <input type="text" placeholder="MM/YY" class="input">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                    <input type="text" placeholder="123" class="input">
                                </div>
                            </div>
                        </div>

                        <button @click="processPayment" :disabled="isProcessing"
                            :class="{ 'opacity-50 cursor-not-allowed': isProcessing }"
                            class="w-full btn btn-primary py-4 text-lg mt-6">
                            <span x-show="!isProcessing">Place Order</span>
                            <span x-show="isProcessing">Processing...</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>

                    <!-- Items -->
                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        <?php $__currentLoopData = $cart['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center space-x-3">
                                <img src="<?php echo e($item['image'] ?? 'https://placehold.co/600x400?text=No+Image'); ?>"
                                    alt="<?php echo e($item['name']); ?>" class="w-16 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <p class="font-medium text-sm"><?php echo e($item['name']); ?></p>
                                    <p class="text-sm text-gray-600">Qty: <?php echo e($item['quantity']); ?></p>
                                </div>
                                <span
                                    class="font-semibold">$<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Totals -->
                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>$<?php echo e(number_format($cart['subtotal'], 2)); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span>$0.00</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Tax</span>
                            <span>$<?php echo e(number_format($cart['tax'], 2)); ?></span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-900 pt-2 border-t">
                            <span>Total</span>
                            <span>$<?php echo e(number_format($cart['total'], 2)); ?></span>
                        </div>
                    </div>

                    <!-- Secure Checkout Badge -->
                    <div class="mt-6 flex items-center justify-center text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Secure Checkout
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\smart_cart_e_commerce\resources\views/checkout/index.blade.php ENDPATH**/ ?>