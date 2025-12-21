

<?php $__env->startSection('title', 'Products - SmartCart'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <aside class="lg:w-64 space-y-6">
                <div class="card p-6">
                    <h3 class="font-bold text-lg mb-4">Filters</h3>

                    <form method="GET" action="<?php echo e(route('products.index')); ?>" class="space-y-6">
                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_price" value="<?php echo e($filters['min_price'] ?? ''); ?>"
                                    placeholder="Min" class="input">
                                <input type="number" name="max_price" value="<?php echo e($filters['max_price'] ?? ''); ?>"
                                    placeholder="Max" class="input">
                            </div>
                        </div>

                        <!-- In Stock -->
                        <div class="flex items-center">
                            <input type="checkbox" name="in_stock" value="1"
                                <?php echo e(!empty($filters['in_stock']) ? 'checked' : ''); ?>

                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <label class="ml-2 text-sm text-gray-700">In Stock Only</label>
                        </div>

                        <!-- Buttons -->
                        <div class="space-y-2">
                            <button type="submit" class="w-full btn btn-primary">
                                Apply Filters
                            </button>
                            <a href="<?php echo e(route('products.index')); ?>" class="block w-full btn btn-secondary text-center">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                        <p class="text-gray-600 mt-1"><?php echo e($products->total()); ?> products found</p>
                    </div>

                    <!-- Sort -->
                    <div>
                        <form method="GET" action="<?php echo e(route('products.index')); ?>" class="inline-block">
                            <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key !== 'sort' && $value): ?>
                                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <select name="sort" onchange="this.form.submit()" class="input">
                                <option value="newest">Newest</option>
                                <option value="price_low" <?php echo e(($filters['sort'] ?? '') === 'price_low' ? 'selected' : ''); ?>>
                                    Price: Low to High</option>
                                <option value="price_high"
                                    <?php echo e(($filters['sort'] ?? '') === 'price_high' ? 'selected' : ''); ?>>Price: High to Low
                                </option>
                                <option value="name" <?php echo e(($filters['sort'] ?? '') === 'name' ? 'selected' : ''); ?>>Name: A
                                    to Z</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <?php if($products->count() > 0): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    <div class="mt-8">
                        <?php echo e($products->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-16">
                        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                        <p class="mt-2 text-gray-500">Try adjusting your filters</p>
                        <a href="<?php echo e(route('products.index')); ?>" class="mt-4 inline-block btn btn-primary">
                            Clear Filters
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\smart_cart_e_commerce\resources\views/products/index.blade.php ENDPATH**/ ?>