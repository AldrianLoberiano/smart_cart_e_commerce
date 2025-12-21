@extends('layouts.app')

@section('title', 'Privacy Policy - SmartCart')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Privacy Policy</h1>

        <p class="text-gray-600 mb-8">Last Updated: {{ date('F d, Y') }}</p>

        <div class="prose prose-lg max-w-none">
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Introduction</h2>
                <p class="text-gray-700 mb-4">
                    At SmartCart, we take your privacy seriously. This Privacy Policy explains how we collect, use,
                    disclose, and safeguard your information when you visit our website and make purchases.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Information We Collect</h2>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Personal Information</h3>
                <p class="text-gray-700 mb-4">We may collect personal information that you provide to us, including:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Name and contact information (email, phone, address)</li>
                    <li>Payment information (processed securely through our payment provider)</li>
                    <li>Order history and preferences</li>
                    <li>Account credentials</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">Automatically Collected Information</h3>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>IP address and browser information</li>
                    <li>Device information</li>
                    <li>Cookies and similar tracking technologies</li>
                    <li>Usage data and browsing behavior</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">How We Use Your Information</h2>
                <p class="text-gray-700 mb-4">We use the information we collect to:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Process and fulfill your orders</li>
                    <li>Communicate with you about your orders and account</li>
                    <li>Send marketing communications (with your consent)</li>
                    <li>Improve our website and services</li>
                    <li>Prevent fraud and enhance security</li>
                    <li>Comply with legal obligations</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Information Sharing</h2>
                <p class="text-gray-700 mb-4">
                    We do not sell or rent your personal information to third parties. We may share your information with:
                </p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li><strong>Service Providers:</strong> Payment processors, shipping companies, and marketing services
                    </li>
                    <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
                    <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets
                    </li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Security</h2>
                <p class="text-gray-700 mb-4">
                    We implement appropriate technical and organizational security measures to protect your personal
                    information. However, no method of transmission over the internet is 100% secure, and we cannot
                    guarantee absolute security.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Rights</h2>
                <p class="text-gray-700 mb-4">You have the right to:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Access and receive a copy of your personal information</li>
                    <li>Correct inaccurate or incomplete information</li>
                    <li>Request deletion of your information</li>
                    <li>Opt-out of marketing communications</li>
                    <li>Object to or restrict certain data processing</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Cookies</h2>
                <p class="text-gray-700 mb-4">
                    We use cookies and similar technologies to enhance your browsing experience, analyze site traffic, and
                    personalize content. You can control cookie preferences through your browser settings.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Children's Privacy</h2>
                <p class="text-gray-700 mb-4">
                    Our services are not directed to children under 13. We do not knowingly collect personal information
                    from children under 13. If you believe we have collected such information, please contact us
                    immediately.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to This Policy</h2>
                <p class="text-gray-700 mb-4">
                    We may update this Privacy Policy from time to time. We will notify you of any changes by posting the
                    new policy on this page and updating the "Last Updated" date.
                </p>
            </section>

            <div class="bg-purple-50 border-l-4 border-purple-500 p-4 mt-8">
                <p class="text-purple-700">
                    <strong>Questions about privacy?</strong> Contact us at privacy@smartcart.com or call 1-800-SMARTCART.
                </p>
            </div>
        </div>
    </div>
@endsection
