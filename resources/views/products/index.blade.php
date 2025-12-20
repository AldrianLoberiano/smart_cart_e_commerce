@extends('layouts.app')

@section('title', 'Products - SmartCart')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <aside class="lg:w-64 space-y-6">
                <div class="card p-6">
                    <h3 class="font-bold text-lg mb-4">Filters</h3>

                    <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                                placeholder="Search products..." class="input">
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}"
                                    placeholder="Min" class="input">
                                <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}"
                                    placeholder="Max" class="input">
                            </div>
                        </div>

                        <!-- In Stock -->
                        <div class="flex items-center">
                            <input type="checkbox" name="in_stock" value="1"
                                {{ !empty($filters['in_stock']) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <label class="ml-2 text-sm text-gray-700">In Stock Only</label>
                        </div>

                        <!-- Buttons -->
                        <div class="space-y-2">
                            <button type="submit" class="w-full btn btn-primary">
                                Apply Filters
                            </button>
                            <a href="{{ route('products.index') }}" class="block w-full btn btn-secondary text-center">
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
                        <p class="text-gray-600 mt-1">{{ $products->total() }} products found</p>
                    </div>

                    <!-- Sort -->
                    <div>
                        <form method="GET" action="{{ route('products.index') }}" class="inline-block">
                            @foreach ($filters as $key => $value)
                                @if ($key !== 'sort_by' && $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <select name="sort_by" onchange="this.form.submit()" class="input">
                                <option value="created_at"
                                    {{ ($filters['sort_by'] ?? '') === 'created_at' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc"
                                    {{ ($filters['sort_by'] ?? '') === 'price_asc' ? 'selected' : '' }}>Price: Low to High
                                </option>
                                <option value="price_desc"
                                    {{ ($filters['sort_by'] ?? '') === 'price_desc' ? 'selected' : '' }}>Price: High to Low
                                </option>
                                <option value="name" {{ ($filters['sort_by'] ?? '') === 'name' ? 'selected' : '' }}>Name:
                                    A to Z</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                @if ($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                        <p class="mt-2 text-gray-500">Try adjusting your filters</p>
                        <a href="{{ route('products.index') }}" class="mt-4 inline-block btn btn-primary">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
