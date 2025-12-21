

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
            <p class="mt-2 text-gray-600">View and manage your order history</p>
        </div>

        <?php if($orders->isEmpty()): ?>
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No orders yet</h3>
                <p class="mt-2 text-gray-500">Start shopping to see your orders here</p>
                <div class="mt-6">
                    <a href="<?php echo e(route('home')); ?>"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Continue Shopping
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <!-- Order Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Order Number</p>
                                        <p class="font-medium text-gray-900">#<?php echo e($order->order_number); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Date</p>
                                        <p class="font-medium text-gray-900"><?php echo e($order->created_at->format('M d, Y')); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Total</p>
                                        <p class="font-medium text-gray-900">$<?php echo e(number_format($order->total, 2)); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Status</p>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?php if($order->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($order->status === 'processing'): ?> bg-blue-100 text-blue-800
                                        <?php elseif($order->status === 'shipped'): ?> bg-purple-100 text-purple-800
                                        <?php elseif($order->status === 'delivered'): ?> bg-green-100 text-green-800
                                        <?php elseif($order->status === 'cancelled'): ?> bg-red-100 text-red-800 <?php endif; ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <a href="<?php echo e(route('orders.show', $order)); ?>"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="px-6 py-4">
                            <div class="space-y-4">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <?php if($item->product && $item->product->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>"
                                                    alt="<?php echo e($item->product_name); ?>" class="h-16 w-16 rounded object-cover">
                                            <?php else: ?>
                                                <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900"><?php echo e($item->product_name); ?></p>
                                            <p class="text-sm text-gray-500">Quantity: <?php echo e($item->quantity); ?></p>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            $<?php echo e(number_format($item->price * $item->quantity, 2)); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\SmartCart – Modern E-Commerce Web Application\smart_cart\resources\views/orders/index.blade.php ENDPATH**/ ?>