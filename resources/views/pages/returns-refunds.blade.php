@extends('layouts.app')

@section('title', 'Returns & Refunds Policy - SmartCart')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Returns & Refunds Policy</h1>

        <div class="prose prose-lg max-w-none">
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">30-Day Return Policy</h2>
                <p class="text-gray-700 mb-4">
                    We want you to be completely satisfied with your purchase. If you're not happy with your order, you can
                    return most items within 30 days of delivery for a full refund or exchange.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Return Eligibility</h2>
                <p class="text-gray-700 mb-4">To be eligible for a return, items must:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Be unused and in the same condition as received</li>
                    <li>Be in the original packaging with all tags attached</li>
                    <li>Include the original receipt or proof of purchase</li>
                    <li>Be returned within 30 days of delivery</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Non-Returnable Items</h2>
                <p class="text-gray-700 mb-4">The following items cannot be returned:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Personalized or custom-made products</li>
                    <li>Clearance or final sale items</li>
                    <li>Opened software or digital products</li>
                    <li>Health and personal care items</li>
                    <li>Gift cards</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">How to Return an Item</h2>
                <ol class="list-decimal pl-6 text-gray-700 space-y-2">
                    <li>Log into your account and go to your order history</li>
                    <li>Select the item(s) you wish to return</li>
                    <li>Print the prepaid return shipping label</li>
                    <li>Package the item securely with all original materials</li>
                    <li>Drop off at any authorized shipping location</li>
                </ol>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Refund Processing</h2>
                <p class="text-gray-700 mb-4">
                    Once we receive your return, we will inspect the item and process your refund within 5-7 business days.
                    Refunds will be credited to your original payment method. Please allow 3-5 business days for the refund
                    to appear in your account.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Exchanges</h2>
                <p class="text-gray-700 mb-4">
                    If you need to exchange an item for a different size or color, please initiate a return and place a new
                    order for the desired item. This ensures you receive your new item as quickly as possible.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Return Shipping Costs</h2>
                <p class="text-gray-700 mb-4">
                    We provide free return shipping for defective items or incorrect orders. For standard returns, a $5.99
                    return shipping fee will be deducted from your refund.
                </p>
            </section>

            <div class="bg-green-50 border-l-4 border-green-500 p-4 mt-8">
                <p class="text-green-700">
                    <strong>Need help with a return?</strong> Contact our customer service team at returns@smartcart.com or
                    call 1-800-SMARTCART.
                </p>
            </div>
        </div>
    </div>
@endsection
