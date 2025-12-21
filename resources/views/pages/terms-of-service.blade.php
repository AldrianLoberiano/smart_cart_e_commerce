@extends('layouts.app')

@section('title', 'Terms of Service - SmartCart')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Terms of Service</h1>

        <p class="text-gray-600 mb-8">Last Updated: {{ date('F d, Y') }}</p>

        <div class="prose prose-lg max-w-none">
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Agreement to Terms</h2>
                <p class="text-gray-700 mb-4">
                    By accessing or using SmartCart, you agree to be bound by these Terms of Service and all applicable laws
                    and regulations. If you do not agree with any of these terms, you are prohibited from using this site.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Use License</h2>
                <p class="text-gray-700 mb-4">
                    Permission is granted to temporarily access the materials on SmartCart's website for personal,
                    non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and
                    under this license you may not:
                </p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Modify or copy the materials</li>
                    <li>Use the materials for any commercial purpose</li>
                    <li>Attempt to reverse engineer any software contained on the website</li>
                    <li>Remove any copyright or proprietary notations from the materials</li>
                    <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Account Terms</h2>
                <p class="text-gray-700 mb-4">When you create an account with us, you must:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Provide accurate, complete, and current information</li>
                    <li>Maintain the security of your password</li>
                    <li>Be at least 18 years old or have parental consent</li>
                    <li>Accept responsibility for all activities under your account</li>
                    <li>Not use the account for any illegal or unauthorized purpose</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Products and Services</h2>
                <p class="text-gray-700 mb-4">
                    All product descriptions, prices, and availability are subject to change without notice. We reserve the
                    right to limit quantities and refuse service to anyone. Product images are for illustration purposes and
                    may not exactly represent the actual product.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Pricing and Payment</h2>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>All prices are in USD and subject to change without notice</li>
                    <li>We accept major credit cards, debit cards, and PayPal</li>
                    <li>Payment is processed securely through our payment provider</li>
                    <li>We reserve the right to refuse or cancel orders at any time</li>
                    <li>Pricing errors may be corrected, and orders may be cancelled</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Order Acceptance</h2>
                <p class="text-gray-700 mb-4">
                    All orders are subject to acceptance by SmartCart. We may, in our sole discretion, refuse or cancel any
                    order for any reason including but not limited to product availability, errors in pricing or product
                    information, or suspected fraud.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Intellectual Property</h2>
                <p class="text-gray-700 mb-4">
                    The content on this website, including but not limited to text, graphics, logos, images, and software,
                    is the property of SmartCart and is protected by copyright and trademark laws. Unauthorized use is
                    prohibited.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Limitation of Liability</h2>
                <p class="text-gray-700 mb-4">
                    SmartCart shall not be liable for any indirect, incidental, special, consequential, or punitive damages
                    resulting from your use of or inability to use the service, even if we have been advised of the
                    possibility of such damages.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Disclaimer</h2>
                <p class="text-gray-700 mb-4">
                    The materials on SmartCart's website are provided on an 'as is' basis. SmartCart makes no warranties,
                    expressed or implied, and hereby disclaims all other warranties including, without limitation, implied
                    warranties of merchantability, fitness for a particular purpose, or non-infringement of intellectual
                    property.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Governing Law</h2>
                <p class="text-gray-700 mb-4">
                    These terms and conditions are governed by and construed in accordance with the laws of the United
                    States, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to Terms</h2>
                <p class="text-gray-700 mb-4">
                    We reserve the right to modify these terms at any time. Changes will be effective immediately upon
                    posting to the website. Your continued use of the website following any changes constitutes acceptance
                    of those changes.
                </p>
            </section>

            <div class="bg-red-50 border-l-4 border-red-500 p-4 mt-8">
                <p class="text-red-700">
                    <strong>Questions about our terms?</strong> Contact us at legal@smartcart.com or call 1-800-SMARTCART.
                </p>
            </div>
        </div>
    </div>
@endsection
