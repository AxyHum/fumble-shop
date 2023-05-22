<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function checkout(Product $product)
    {
        $order = Order::create([
            'amount' => $product->price,
            'product_id' => $product->id,
            'payment_method' => 'payment_channel'
        ]);

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => $this->makeCallbackUrl($order, 'success'),
            'cancel_url' => $this->makeCallbackUrl($order, 'cancel'),
            'line_items' => [
                [
                    'price' => $product->stripe_price,
                    'quantity' => 1,
                    'adjustable_quantity' => [
                        'enabled' => true,
                        'minimum' => 1,
                        'maximum' => 10,
                    ],
                ],
            ],
            'mode' => 'payment',
        ]);

        $Html = '<script src="https://js.stripe.com/v3/"></script>';
        $Html .= '<script type="text/javascript">let stripe = Stripe("' . env('STRIPE_KEY') . '");';
        $Html .= 'stripe.redirectToCheckout({ sessionId: "' . $checkout->id . '" }); </script>';

        echo $Html;
    }

    private function makeCallbackUrl($order, $status)
    {
        return url("/payments/verify/Stripe?status=$status&order_id=$order->id&session_id={CHECKOUT_SESSION_ID}");
    }
}
