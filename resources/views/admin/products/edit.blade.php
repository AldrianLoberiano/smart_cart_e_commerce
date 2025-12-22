@extends('layouts.admin')

@section('title', 'Edit Product - Admin')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('admin.products.index') }}"
                    class="text-primary-600 hover:text-primary-700 flex items-center mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Products
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                class="input w-full @error('name') border-red-500 @enderror"
                                placeholder="e.g., iPhone 15 Pro">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                            <textarea name="short_description" rows="2"
                                class="input w-full @error('short_description') border-red-500 @enderror"
                                placeholder="Brief product description (max 500 characters)">{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
                            <textarea name="description" rows="6" class="input w-full @error('description') border-red-500 @enderror"
                                placeholder="Detailed product description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Categories</label>
                            <div
                                class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-3">
                                @foreach ($categories as $category)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="rounded text-primary-600">
                                        <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Pricing</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                    step="0.01" min="0" required
                                    class="input w-full pl-8 @error('price') border-red-500 @enderror">
                            </div>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Compare at Price</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                                <input type="number" name="compare_price"
                                    value="{{ old('compare_price', $product->compare_price) }}" step="0.01"
                                    min="0"
                                    class="input w-full pl-8 @error('compare_price') border-red-500 @enderror">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Original price for showing discounts</p>
                            @error('compare_price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cost per Item</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                                <input type="number" name="cost" value="{{ old('cost', $product->cost) }}"
                                    step="0.01" min="0"
                                    class="input w-full pl-8 @error('cost') border-red-500 @enderror">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">For profit tracking</p>
                            @error('cost')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Inventory</h2>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SKU *</label>
                                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required
                                    class="input w-full @error('sku') border-red-500 @enderror"
                                    placeholder="e.g., IPH-15P-256-BLK">
                                @error('sku')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                    min="0" required class="input w-full @error('stock') border-red-500 @enderror">
                                @error('stock')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Low Stock Threshold</label>
                            <input type="number" name="low_stock_threshold"
                                value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" min="0"
                                class="input w-full @error('low_stock_threshold') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Alert when stock falls below this number</p>
                            @error('low_stock_threshold')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="track_stock" value="1"
                                {{ old('track_stock', $product->track_stock) ? 'checked' : '' }}
                                class="rounded text-primary-600">
                            <label class="ml-2 text-sm text-gray-700">Track stock quantity</label>
                        </div>
                    </div>
                </div>

                <!-- Shipping -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight</label>
                            <input type="number" name="weight" value="{{ old('weight', $product->weight) }}"
                                step="0.01" min="0"
                                class="input w-full @error('weight') border-red-500 @enderror">
                            @error('weight')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight Unit</label>
                            <select name="weight_unit" class="input w-full">
                                <option value="kg"
                                    {{ old('weight_unit', $product->weight_unit) === 'kg' ? 'selected' : '' }}>Kilograms
                                    (kg)</option>
                                <option value="g"
                                    {{ old('weight_unit', $product->weight_unit) === 'g' ? 'selected' : '' }}>Grams (g)
                                </option>
                                <option value="lb"
                                    {{ old('weight_unit', $product->weight_unit) === 'lb' ? 'selected' : '' }}>Pounds (lb)
                                </option>
                                <option value="oz"
                                    {{ old('weight_unit', $product->weight_unit) === 'oz' ? 'selected' : '' }}>Ounces (oz)
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Product Images</h2>

                    <!-- Current Images -->
                    @if ($product->images && count($product->images) > 0)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($product->images as $index => $image)
                                    <div class="relative group">
                                        <img src="{{ $image }}" alt="Product image"
                                            class="w-full h-32 object-cover rounded-lg">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <label class="flex items-center text-white cursor-pointer">
                                                <input type="checkbox" name="remove_images[]"
                                                    value="{{ $index }}" class="mr-2">
                                                <span class="text-sm">Remove</span>
                                            </label>
                                        </div>
                                        @if ($index === 0)
                                            <span
                                                class="absolute top-2 left-2 bg-primary-600 text-white text-xs px-2 py-1 rounded">Primary</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Upload New Images -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Add New Images</label>
                        <input type="file" name="new_images[]" multiple accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        <p class="text-xs text-gray-500 mt-1">Accepted: JPG, PNG, WEBP. Max size: 2MB per image. Max total:
                            5 images</p>
                        @error('new_images')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Status</h2>

                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="rounded text-primary-600">
                            <label class="ml-2 text-sm text-gray-700">Active (visible in store)</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="rounded text-primary-600">
                            <label class="ml-2 text-sm text-gray-700">Featured product</label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('products.show', $product) }}" target="_blank"
                            class="text-primary-600 hover:text-primary-700 text-sm">
                            View in Store →
                        </a>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
