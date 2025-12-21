@extends('layouts.app')

@section('title', 'About Us - SmartCart')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">About SmartCart</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Your trusted partner for quality products and exceptional shopping experiences since 2020
            </p>
        </div>

        <!-- Our Story -->
        <section class="mb-16">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <p class="text-gray-700 mb-4">
                        SmartCart was founded with a simple mission: to make online shopping easy, affordable, and enjoyable
                        for everyone. What started as a small operation has grown into a trusted e-commerce platform serving
                        thousands of customers nationwide.
                    </p>
                    <p class="text-gray-700 mb-4">
                        We believe that shopping online should be more than just transactions—it should be an experience.
                        That's why we carefully curate our product selection, ensuring every item meets our high standards
                        for quality and value.
                    </p>
                    <p class="text-gray-700">
                        Today, we're proud to offer a diverse range of products from electronics to home goods, all backed
                        by our commitment to customer satisfaction and exceptional service.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg p-12 text-white">
                    <div class="text-center mb-8">
                        <div class="text-6xl font-bold mb-2">5+</div>
                        <p class="text-xl">Years in Business</p>
                    </div>
                    <div class="text-center mb-8">
                        <div class="text-6xl font-bold mb-2">50K+</div>
                        <p class="text-xl">Happy Customers</p>
                    </div>
                    <div class="text-center">
                        <div class="text-6xl font-bold mb-2">10K+</div>
                        <p class="text-xl">Products Available</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Values -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Our Values</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Quality First</h3>
                    <p class="text-gray-700">
                        We handpick every product to ensure it meets our rigorous quality standards before it reaches you.
                    </p>
                </div>

                <div class="card p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Best Prices</h3>
                    <p class="text-gray-700">
                        We work directly with suppliers to bring you competitive pricing without compromising on quality.
                    </p>
                </div>

                <div class="card p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Customer Care</h3>
                    <p class="text-gray-700">
                        Your satisfaction is our priority. Our dedicated support team is always here to help you.
                    </p>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="mb-16 bg-gray-50 rounded-lg p-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Choose SmartCart?</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Fast & Free Shipping</h3>
                        <p class="text-gray-700">Free standard shipping on orders over $50 with tracking on every order.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">30-Day Returns</h3>
                        <p class="text-gray-700">Not satisfied? Return any item within 30 days for a full refund.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Secure Payments</h3>
                        <p class="text-gray-700">Your payment information is protected with industry-standard encryption.
                        </p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">24/7 Support</h3>
                        <p class="text-gray-700">Our customer service team is available around the clock to assist you.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Start Shopping?</h2>
            <p class="text-xl text-gray-600 mb-8">Discover our wide selection of quality products today</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('products.index') }}" class="btn btn-primary px-8 py-3">
                    Browse Products
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary px-8 py-3">
                    Contact Us
                </a>
            </div>
        </section>
    </div>
@endsection
