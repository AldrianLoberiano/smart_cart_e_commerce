@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
    <div class="p-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-1">Overview of your store</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Products -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_products']) }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $stats['active_products'] }} active</p>
                </div>

                <!-- Low Stock -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-600">Low Stock</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['low_stock']) }}</p>
                    <a href="{{ route('admin.products.index', ['stock_status' => 'low_stock']) }}"
                        class="text-sm text-primary-600 hover:text-primary-700 mt-2 inline-block">View →</a>
                </div>

                <!-- Out of Stock -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-600">Out of Stock</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['out_of_stock']) }}</p>
                    <a href="{{ route('admin.products.index', ['stock_status' => 'out_of_stock']) }}"
                        class="text-sm text-primary-600 hover:text-primary-700 mt-2 inline-block">View →</a>
                </div>

                <!-- Total Orders -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_orders']) }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $stats['pending_orders'] }} pending</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.products.create') }}"
                        class="flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-primary-300 hover:shadow-sm transition">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-900">Add Product</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-primary-300 hover:shadow-sm transition">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-900">Manage Products</span>
                    </a>
                    <a href="{{ route('orders.index') }}"
                        class="flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:border-primary-300 hover:shadow-sm transition">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-900">View Orders</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
