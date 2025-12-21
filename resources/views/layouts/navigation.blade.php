<nav class="bg-white shadow-sm sticky top-0 z-40" x-data="search">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 4h14v2H7zm0 4h14v2H7zm0 4h14v2H7zM3 4h2v2H3zm0 4h2v2H3zm0 4h2v2H3z" />
                    </svg>
                    <span class="text-2xl font-bold text-gray-900">SmartCart</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 max-w-2xl mx-8 relative">
                <div class="relative">
                    <input type="text" id="search-query" name="search" x-model="query"
                        placeholder="Search products..." autocomplete="off"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <!-- Loading indicator -->
                    <div x-show="isLoading" class="absolute right-3 top-3">
                        <svg class="animate-spin h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Search Results Dropdown -->
                <div x-show="isOpen" @click.away="isOpen = false" x-transition
                    class="absolute top-full mt-2 w-full bg-white rounded-lg shadow-lg max-h-96 overflow-y-auto">
                    <template x-if="results.length > 0">
                        <ul class="py-2">
                            <template x-for="product in results" :key="product.id">
                                <li>
                                    <a :href="`/products/${product.slug}`"
                                        class="flex items-center px-4 py-3 hover:bg-gray-50 transition">
                                        <img :src="product.primary_image || 'https://placehold.co/600x400?text=No+Image'"
                                            :alt="product.name" class="w-12 h-12 object-cover rounded">
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900" x-text="product.name"></p>
                                            <p class="text-sm text-primary-600 font-semibold"
                                                x-text="formatPrice(product.price)"></p>
                                        </div>
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </template>
                    <template x-if="results.length === 0 && query.length >= 2 && !isLoading">
                        <div class="px-4 py-8 text-center text-gray-500">
                            No products found
                        </div>
                    </template>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('products.index') }}"
                    class="text-gray-700 hover:text-primary-600 font-medium transition">
                    Products
                </a>

                <!-- Cart Button -->
                <a href="{{ route('cart.index') }}"
                    class="relative p-2 text-gray-700 hover:text-primary-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span x-show="itemCount > 0"
                        class="absolute -top-1 -right-1 bg-primary-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
                        x-text="itemCount"></span>
                </a>

                <!-- User Menu -->
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 text-gray-700 hover:text-primary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 font-medium transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
