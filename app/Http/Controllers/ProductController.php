<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Exception;
use HTTP_Request2_LogicException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Services\HelloAssoApiWrapper;
use stdClass;
use Stripe\Exception\ApiErrorException;

class ProductController extends Controller
{
    /**
     * @throws ApiErrorException
     * @throws HTTP_Request2_LogicException
     * @throws Exception
     */
    public function checkout(Product $product)
    {
        $order = Order::create([
            'amount' => $product->price,
            'product_id' => $product->id,
            'payment_method' => 'payment_channel'
        ]);

        $helloassoApiWrapper = new HelloAssoApiWrapper(Config::get('services.helloasso'));

        $model = new stdClass();

        $model->id = $order->id;
        $model->product = $product;
        $model->method = 1;
//        return $model;
        $response = $helloassoApiWrapper->initCart($model);

        if(isset($response->redirectUrl)) {
            // We can store checkout id somewhere
            //$response->checkoutIntentId;

            // then redirect to HelloAsso
            header('Location:' . $response->redirectUrl);
            exit();
        } else if (isset($response)) {
            $model->error = $response->error;
            return ['form', $model];
        } else {
            $model->error = "Une erreur inconnue s'est produite";
            return ['form', $model];
        }
//
//        $order = Order::create([
//            'amount' => $product->price,
//            'product_id' => $product->id,
//            'payment_method' => 'payment_channel'
//        ]);
//
//        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
//        $checkout = $stripe->checkout->sessions->create([
//            'success_url' => $this->makeCallbackUrl($order, 'success'),
//            'cancel_url' => url('/'),
//            'payment_method_types' => ['card', 'paypal'],
//            'line_items' => [
//                [
//                    'price' => $product->stripe_price,
//                    'quantity' => 1,
//                    'adjustable_quantity' => [
//                        'enabled' => true,
//                        'minimum' => 1,
//                        'maximum' => 10,
//                    ],
//                ],
//            ],
//            'invoice_creation' => [
//                'enabled' => true,
//            ],
//            'mode' => 'payment',
//        ]);
//
//        $Html = '<script src="https://js.stripe.com/v3/"></script>';
//        $Html .= '<script type="text/javascript">let stripe = Stripe("' . env('STRIPE_KEY') . '");';
//        $Html .= 'stripe.redirectToCheckout({ sessionId: "' . $checkout->id . '" }); </script>';
//
//        echo $Html;
    }

    private function makeCallbackUrl($order, $status)
    {
        return url("/payments/verify/Stripe?status=$status&order_id=$order->id&session_id={CHECKOUT_SESSION_ID}");
    }
}
