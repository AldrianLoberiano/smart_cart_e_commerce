<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-white font-bold text-lg mb-4">SmartCart</h3>
                <p class="text-sm">
                    Your one-stop shop for quality products at great prices.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Products</a></li>
                    <li><a href="#" class="hover:text-white transition">About Us</a></li>
                    <li><a href="#" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h3 class="text-white font-semibold mb-4">Customer Service</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Shipping Policy</a></li>
                    <li><a href="#" class="hover:text-white transition">Returns & Refunds</a></li>
                    <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-white font-semibold mb-4">Newsletter</h3>
                <p class="text-sm mb-4">Subscribe to get special offers and updates.</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="flex-1 px-4 py-2 rounded-l-lg text-gray-900">
                    <button class="bg-primary-600 px-4 py-2 rounded-r-lg hover:bg-primary-700 transition">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-sm text-center">
            <p>&copy; {{ date('Y') }} SmartCart. All rights reserved.</p>
        </div>
    </div>
</footer>
