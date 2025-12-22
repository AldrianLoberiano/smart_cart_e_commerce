

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Enhanced Header -->
            <div class="mb-8">
                <nav class="flex items-center text-sm text-gray-600 mb-4">
                    <a href="<?php echo e(route('home')); ?>" class="hover:text-primary-600 transition">Home</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="<?php echo e(route('account.index')); ?>" class="hover:text-primary-600 transition">Account</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-900 font-medium">My Orders</span>
                </nav>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">My Orders</h1>
                        <p class="text-gray-600">Track and manage your order history</p>
                    </div>
                    <a href="<?php echo e(route('account.index')); ?>"
                        class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Account
                    </a>
                </div>
            </div>

        <?php if($orders->isEmpty()): ?>
            <div class="bg-white rounded-2xl shadow-lg p-16 text-center border border-gray-100">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-primary-50 to-primary-100 mb-6">
                    <svg class="w-12 h-12 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Start your shopping journey and discover amazing products in our store</p>
                <a href="<?php echo e(route('home')); ?>"
                    class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Start Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex flex-wrap items-center gap-x-8 gap-y-3">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Order Number</p>
                                        <p class="font-bold text-gray-900 text-lg">#<?php echo e($order->order_number); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Date Placed</p>
                                        <p class="font-semibold text-gray-900"><?php echo e($order->created_at->format('M d, Y')); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($order->created_at->format('h:i A')); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Total Amount</p>
                                        <p class="font-bold text-primary-600 text-lg">$<?php echo e(number_format($order->total, 2)); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Status</p>
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold shadow-sm
                                        <?php if($order->status === 'pending'): ?> bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300
                                        <?php elseif($order->status === 'processing'): ?> bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300
                                        <?php elseif($order->status === 'shipped'): ?> bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 border border-purple-300
                                        <?php elseif($order->status === 'delivered'): ?> bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300
                                        <?php elseif($order->status === 'cancelled'): ?> bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 <?php endif; ?>">
                                            <span class="w-2 h-2 rounded-full mr-1.5
                                                <?php if($order->status === 'pending'): ?> bg-yellow-600
                                                <?php elseif($order->status === 'processing'): ?> bg-blue-600
                                                <?php elseif($order->status === 'shipped'): ?> bg-purple-600
                                                <?php elseif($order->status === 'delivered'): ?> bg-green-600
                                                <?php elseif($order->status === 'cancelled'): ?> bg-red-600 <?php endif; ?>">
                                            </span>
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <a href="<?php echo e(route('orders.show', $order)); ?>"
                                        class="inline-flex items-center px-5 py-2.5 border-2 border-primary-600 rounded-xl shadow-sm text-sm font-semibold text-primary-600 bg-white hover:bg-primary-50 hover:shadow-md transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="px-6 py-5 bg-white">
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Order Items (<?php echo e($order->items->count()); ?>)
                            </h4>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex-shrink-0">
                                            <?php if($item->product && $item->product->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>"
                                                    alt="<?php echo e($item->product_name); ?>" class="h-20 w-20 rounded-xl object-cover shadow-md border-2 border-white">
                                            <?php else: ?>
                                                <div class="h-20 w-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center shadow-md border-2 border-white">
                                                    <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 mb-1"><?php echo e($item->product_name); ?></p>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                    Qty: <strong class="ml-1 text-gray-900"><?php echo e($item->quantity); ?></strong>
                                                </span>
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Price: <strong class="ml-1 text-gray-900">$<?php echo e(number_format($item->price, 2)); ?></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-gray-500 mb-1">Subtotal</p>
                                            <p class="text-lg font-bold text-gray-900">
                                                $<?php echo e(number_format($item->price * $item->quantity, 2)); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <?php if($orders->hasPages()): ?>
                <div class="mt-8">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\smart_cart_e_commerce\resources\views/orders/index.blade.php ENDPATH**/ ?>