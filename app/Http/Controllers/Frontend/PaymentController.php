<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlaceMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function show(Order $order, Request $request)
    {
        $customer = Auth::guard('customer')->user();

        Stripe::setApiKey(config('services.stripe.secret'));

        // dd($order);

        $amountInCents = (int) round($order->total * 100);

        $paymentIntent = PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
            'payment_method_configuration' => 'pmc_1TtNWIBXeacV7G2duUtzMeHx',
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ],

        ]);

        $order->update(['stripe_payment_intent_id' => $paymentIntent->id]);


        return Inertia::render('Frontend/Payment/Index', [
            'clientSecret' => $paymentIntent->client_secret,
            'stripeKey'    => config('services.stripe.key'),
            'amount'       => $order->total,
            'order'        => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total' => $order->total,
            ],
        ]);
    }
    public function success(Order $order, Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntentId = $request->query('payment_intent');

        if (! $paymentIntentId) {
            return Inertia::render('Frontend/Payment/Failed', [
                'order' => null,
                'message' => 'We could not find your order.',
            ]);
        }

        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

        $order = Order::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if (! $order) {
            return Inertia::render('Frontend/Payment/Failed', [
                'order' => null,
                'message' => 'We could not find your orders.',
            ]);
        }

        if ($paymentIntent->status === 'succeeded') {
            if ($order->payment_status !== 'paid') {
                $order->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                ]);

                $order->load('orderItems');

                Mail::to($order->email)->send(new OrderPlaceMail($order));
            }

            return Inertia::render('Frontend/Payment/Success', [
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total' => $order->total,
                    'status_label' => ucfirst($order->status),
                ],
            ]);
        }

        return Inertia::render('Frontend/Payment/Failed', [
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
            ],
            'message' => $paymentIntent->last_payment_error->message ?? null,
        ]);
    }
}
