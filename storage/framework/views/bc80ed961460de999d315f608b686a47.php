

<?php $__env->startSection('title', 'My Account'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Breadcrumb -->
        <div class="mb-8">
            <nav class="flex items-center text-sm text-gray-600 mb-4">
                <a href="<?php echo e(route('home')); ?>" class="hover:text-primary-600 transition">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium">My Account</span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome back, <?php echo e(auth()->user()->name); ?>!</h1>
                    <p class="text-gray-600">Manage your profile, orders, and preferences</p>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Last login: <?php echo e(auth()->user()->updated_at->diffForHumans()); ?></span>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-900 px-6 py-4 rounded-r-lg mb-8 shadow-sm animate-fade-in-down">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="ml-3 font-medium"><?php echo e(session('success')); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Enhanced Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-6">
                    <!-- Profile Header -->
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-6 text-white">
                        <div class="flex flex-col items-center">
                            <div class="relative">
                                <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/30 shadow-xl">
                                    <span class="text-4xl font-bold text-white"><?php echo e(substr(auth()->user()->name, 0, 1)); ?></span>
                                </div>
                                <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-400 border-2 border-white rounded-full"></div>
                            </div>
                            <h2 class="text-xl font-bold mt-4 text-center"><?php echo e(auth()->user()->name); ?></h2>
                            <p class="text-sm text-primary-100 text-center"><?php echo e(auth()->user()->email); ?></p>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="p-4 space-y-2">
                        <a href="<?php echo e(route('account.index')); ?>" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('account.index') ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/50' : 'text-gray-700 hover:bg-gray-100'); ?>">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo e(request()->routeIs('account.index') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-white'); ?> transition-all mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span>Overview</span>
                        </a>
                        
                        <a href="<?php echo e(route('orders.index')); ?>" class="group flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-200">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-white transition-all mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <span>My Orders</span>
                            <?php if(auth()->user()->orders()->where('status', 'pending')->count() > 0): ?>
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                <?php echo e(auth()->user()->orders()->where('status', 'pending')->count()); ?>

                            </span>
                            <?php endif; ?>
                        </a>
                        
                        <a href="<?php echo e(route('account.edit')); ?>" class="group flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-200">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-white transition-all mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <span>Edit Profile</span>
                        </a>
                        
                        <a href="<?php echo e(route('account.password')); ?>" class="group flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-200">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-white transition-all mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <span>Security</span>
                        </a>

                        <div class="pt-2 mt-2 border-t border-gray-200">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="group w-full flex items-center px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 transition-all mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Enhanced Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Orders Card -->
                    <div class="group bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative p-6 text-white">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-blue-100 text-sm font-medium mb-1">Total Orders</p>
                            <p class="text-4xl font-bold"><?php echo e(auth()->user()->orders()->count()); ?></p>
                            <p class="text-blue-100 text-xs mt-2">All time</p>
                        </div>
                    </div>

                    <!-- Pending Orders Card -->
                    <div class="group bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative p-6 text-white">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-orange-100 text-sm font-medium mb-1">Pending Orders</p>
                            <p class="text-4xl font-bold"><?php echo e(auth()->user()->orders()->where('status', 'pending')->count()); ?></p>
                            <p class="text-orange-100 text-xs mt-2">Awaiting processing</p>
                        </div>
                    </div>

                    <!-- Member Since Card -->
                    <div class="group bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative p-6 text-white">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-teal-100 text-sm font-medium mb-1">Member Since</p>
                            <p class="text-2xl font-bold"><?php echo e(auth()->user()->created_at->format('M Y')); ?></p>
                            <p class="text-teal-100 text-xs mt-2"><?php echo e(auth()->user()->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Section -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Recent Orders</h3>
                                <p class="text-sm text-gray-600 mt-1">Track your recent purchases</p>
                            </div>
                            <a href="<?php echo e(route('orders.index')); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                                View All
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <?php if($recentOrders->count() > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="group border-2 border-gray-100 hover:border-primary-200 rounded-xl p-5 transition-all duration-300 hover:shadow-lg bg-gradient-to-r from-white to-gray-50">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-lg">Order #<?php echo e($order->order_number); ?></p>
                                            <div class="flex items-center text-sm text-gray-600 mt-1">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <?php echo e($order->created_at->format('M d, Y \a\t h:i A')); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-sm
                                        <?php echo e($order->status === 'delivered' ? 'bg-green-100 text-green-800 border border-green-200' : ''); ?>

                                        <?php echo e($order->status === 'cancelled' ? 'bg-red-100 text-red-800 border border-red-200' : ''); ?>

                                        <?php echo e($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : ''); ?>

                                        <?php echo e($order->status === 'processing' ? 'bg-blue-100 text-blue-800 border border-blue-200' : ''); ?>

                                    ">
                                        <?php if($order->status === 'delivered'): ?>
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        <?php endif; ?>
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            <?php echo e($order->items->count()); ?> <?php echo e(Str::plural('item', $order->items->count())); ?>

                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <p class="text-2xl font-bold text-gray-900">$<?php echo e(number_format($order->total, 2)); ?></p>
                                        <a href="<?php echo e(route('orders.show', $order)); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                            View Details
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No orders yet</h3>
                            <p class="text-gray-600 mb-6">Start shopping to see your orders here</p>
                            <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Start Shopping
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.3s ease-out;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\smart_cart_e_commerce\resources\views/account/index.blade.php ENDPATH**/ ?>