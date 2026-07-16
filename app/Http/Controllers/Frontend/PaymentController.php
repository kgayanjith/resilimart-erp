<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function show(Order $order)
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
}
