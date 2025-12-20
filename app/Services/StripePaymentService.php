<?php

namespace App\Services;

use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create payment intent
     */
    public function createPaymentIntent(Order $order): array
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $order->total * 100, // Convert to cents
                'currency' => 'usd',
                'description' => "Order #{$order->order_number}",
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Confirm payment
     */
    public function confirmPayment(string $paymentIntentId): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status === 'succeeded') {
                return [
                    'success' => true,
                    'payment_intent' => $paymentIntent,
                ];
            }

            return [
                'success' => false,
                'error' => 'Payment not completed',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process refund
     */
    public function refund(Order $order, ?float $amount = null): array
    {
        try {
            $refundAmount = $amount ? $amount * 100 : $order->total * 100;

            $refund = \Stripe\Refund::create([
                'payment_intent' => $order->payment_id,
                'amount' => $refundAmount,
            ]);

            return [
                'success' => true,
                'refund' => $refund,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
