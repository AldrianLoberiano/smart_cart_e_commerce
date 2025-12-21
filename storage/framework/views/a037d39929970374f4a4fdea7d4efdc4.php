<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['product']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['product']); ?>
<?php foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="card group cursor-pointer transition-transform hover:scale-105">
    <div class="relative overflow-hidden aspect-square">
        <img src="<?php echo e($product->primary_image ?? 'https://placehold.co/600x400?text=No+Image'); ?>"
            alt="<?php echo e($product->name); ?>"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">

        <?php if($product->discount_percentage): ?>
            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                -<?php echo e($product->discount_percentage); ?>%
            </div>
        <?php endif; ?>

        <?php if($product->is_featured): ?>
            <div class="absolute top-2 left-2 bg-primary-600 text-white px-2 py-1 rounded-full text-xs font-bold">
                Featured
            </div>
        <?php endif; ?>

        <!-- Quick View Button -->
        <button @click.stop="$dispatch('open-quick-view', { productId: <?php echo e($product->id); ?> })"
            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
            <span class="btn btn-primary">Quick View</span>
        </button>
    </div>

    <div class="p-4">
        <a href="<?php echo e(route('products.show', $product)); ?>" class="block space-y-2">
            <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition line-clamp-2">
                <?php echo e($product->name); ?>

            </h3>

            <?php if($product->average_rating > 0): ?>
                <div class="flex items-center space-x-1">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <svg class="w-4 h-4 <?php echo e($i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300'); ?>"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    <?php endfor; ?>
                    <span class="text-sm text-gray-600">(<?php echo e(number_format($product->average_rating, 1)); ?>)</span>
                </div>
            <?php endif; ?>

            <div class="flex items-center space-x-2">
                <span class="text-xl font-bold text-primary-600">$<?php echo e(number_format($product->price, 2)); ?></span>
                <?php if($product->compare_price && $product->compare_price > $product->price): ?>
                    <span
                        class="text-sm text-gray-500 line-through">$<?php echo e(number_format($product->compare_price, 2)); ?></span>
                <?php endif; ?>
            </div>

            <!-- Stock Information with Progress Bar -->
            <div class="space-y-2">
                <?php if($product->isInStock()): ?>
                    <?php
                        $stockPercentage = ($product->stock / max($product->low_stock_threshold * 2, 100)) * 100;
                        $stockPercentage = min($stockPercentage, 100);
                    ?>
                    <div class="flex items-center justify-between text-sm">
                        <?php if($product->isLowStock()): ?>
                            <span class="badge badge-warning">⚠️ Low Stock</span>
                            <span class="text-orange-600 font-semibold"><?php echo e($product->stock); ?> left</span>
                        <?php else: ?>
                            <span class="badge badge-success">✓ In Stock</span>
                            <span class="text-green-600 font-semibold"><?php echo e($product->stock); ?> available</span>
                        <?php endif; ?>
                    </div>
                    <!-- Stock Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all <?php echo e($product->isLowStock() ? 'bg-orange-500' : 'bg-green-500'); ?>"
                            style="width: <?php echo e($stockPercentage); ?>%"></div>
                    </div>
                <?php else: ?>
                    <div class="flex items-center justify-between text-sm">
                        <span class="badge badge-danger">✗ Out of Stock</span>
                        <span class="text-red-600 font-semibold">0 available</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full bg-red-500" style="width: 0%"></div>
                    </div>
                <?php endif; ?>
            </div>
        </a>

        <button
            @click="$dispatch('open-cart-modal', { product: {
                id: <?php echo e($product->id); ?>,
                name: <?php echo e(Js::from($product->name)); ?>,
                price: <?php echo e($product->price); ?>,
                primary_image: <?php echo e(Js::from($product->primary_image)); ?>,
                stock: <?php echo e($product->stock); ?>,
                isInStock: <?php echo e($product->isInStock() ? 'true' : 'false'); ?>,
                isLowStock: <?php echo e($product->isLowStock() ? 'true' : 'false'); ?>

            } })"
            class="w-full mt-4 btn btn-primary" <?php echo e(!$product->isInStock() ? 'disabled' : ''); ?>>
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Add to Cart
        </button>
    </div>
</div>
<?php /**PATH C:\smart_cart_e_commerce\resources\views/components/product-card.blade.php ENDPATH**/ ?>