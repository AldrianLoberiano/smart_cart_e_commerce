

<?php $__env->startSection('title', 'Products - SmartCart'); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="stockMonitor">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Discover Products</h1>
                <p class="text-gray-600 text-lg">Browse our curated collection of quality items</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <aside class="lg:w-80 space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 sticky top-4">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-xl text-gray-900">Filters</h3>
                        </div>

                        <form method="GET" action="<?php echo e(route('products.index')); ?>" class="space-y-6">
                            <!-- Price Range -->
                            <div>
                                <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Price Range
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="number" name="min_price" value="<?php echo e($filters['min_price'] ?? ''); ?>"
                                        placeholder="Min"
                                        class="px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                                    <input type="number" name="max_price" value="<?php echo e($filters['max_price'] ?? ''); ?>"
                                        placeholder="Max"
                                        class="px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-200"></div>

                            <!-- In Stock -->
                            <div
                                class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                                <input type="checkbox" name="in_stock" value="1"
                                    <?php echo e(!empty($filters['in_stock']) ? 'checked' : ''); ?>

                                    class="w-5 h-5 rounded border-green-300 text-green-600 focus:ring-green-500">
                                <label class="ml-3 text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    In Stock Only
                                </label>
                            </div>

                            <!-- Buttons -->
                            <div class="space-y-3 pt-2">
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Apply Filters
                                </button>
                                <a href="<?php echo e(route('products.index')); ?>"
                                    class="block w-full bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 border-2 border-gray-300 text-center">
                                    Clear Filters
                                </a>
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="flex-1">
                    <!-- Header -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <div class="flex items-center mb-2">
                                    <span
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-bold text-lg mr-3">
                                        <?php echo e($products->total()); ?>

                                    </span>
                                    <span class="text-gray-600 text-lg">Products Available</span>
                                </div>
                            </div>

                            <!-- Sort -->
                            <div class="w-full md:w-auto">
                                <form method="GET" action="<?php echo e(route('products.index')); ?>" class="flex items-center">
                                    <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($key !== 'sort' && $value): ?>
                                            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <label class="text-sm font-medium text-gray-700 mr-3">Sort by:</label>
                                    <select name="sort" onchange="this.form.submit()"
                                        class="px-4 py-3 pr-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all bg-white font-medium">
                                        <option value="newest">Newest First</option>
                                        <option value="price_low"
                                            <?php echo e(($filters['sort'] ?? '') === 'price_low' ? 'selected' : ''); ?>>
                                            Price: Low to High</option>
                                        <option value="price_high"
                                            <?php echo e(($filters['sort'] ?? '') === 'price_high' ? 'selected' : ''); ?>>Price: High
                                            to Low
                                        </option>
                                        <option value="name" <?php echo e(($filters['sort'] ?? '') === 'name' ? 'selected' : ''); ?>>
                                            Name: A to Z</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <?php if($products->count() > 0): ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8 flex justify-center">
                            <?php echo e($products->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="bg-white rounded-2xl shadow-lg p-16 text-center border border-gray-100">
                            <div
                                class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No products found</h3>
                            <p class="text-gray-600 mb-6 text-lg">Try adjusting your filters to see more results</p>
                            <a href="<?php echo e(route('products.index')); ?>"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-semibold hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Clear Filters
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\smart_cart_e_commerce\resources\views/products/index.blade.php ENDPATH**/ ?>