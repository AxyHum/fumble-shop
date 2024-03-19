<?php

namespace App\Http\Controllers;

use HTTP_Request2_LogicException;
use Illuminate\Support\Facades\Config;
use App\Services\HelloAssoApiWrapper;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\Product;
use Stripe\StripeClient;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendOrderShippedMailJob;

class PaymentController extends Controller
{
    /**
     * @throws ApiErrorException
     * @throws HTTP_Request2_LogicException
     */
    public function paymentVerify(Request $request, string $channel)
    {
        $data = $request->all();

        $status = $data['status'];
        $order_id = $data['order_id'];

        $order = Order::find($order_id);

        if (!empty($order)) {
            $order->update(['status' => 'fail']);
        }

        if ($channel == "Stripe") {
            if ($status == 'success' and !empty($request->session_id) and !empty($order)) {
                Stripe::setApiKey(env('STRIPE_SECRET'));

                $session = Session::retrieve($request->session_id);

                if (!empty($session) and $session->payment_status == 'paid') {
                    $order->update([
                        'status' => 'paid',
                        'email' => $session['customer_details']['email'],
                        'name' => $session['customer_details']['name'],
                        'invoice_pdf' => url('/order/invoice?order_id=' . $order->id)
                    ]);

                    Mail::to($order->email)->send(new OrderShipped($order));

                    return redirect('/payments/status?order_id=' . $order->id);
                }
            }
        } else {
            $checkoutId = $data['checkoutIntentId'];
            $code = $data["code"];

            if ($status == 'success' and !empty($order)) {
                $helloassoApiWrapper = new HelloAssoApiWrapper(Config::get('services.helloasso'));
                $response = $helloassoApiWrapper->retrieveCheckout($checkoutId);

                if (!empty($response)) {
                    $order->update([
                        'status' => 'paid',
                        'email' => $response->order->payer->email,
                        'name' => $response->order->payer->firstName,
                        'invoice_pdf' => $response->order->payments[0]->paymentReceiptUrl
                    ]);

                    Mail::to($order->email)->send(new OrderShipped($order));

                    return redirect('/payments/status?order_id=' . $order->id);
                }
            }
        }

        $order->update(['status' => 'fail']);

        return redirect('/');

    }

    public function payStatus(Request $request)
    {
        $order_id = $request->get('order_id');
        $order = Order::find($order_id);

        if (!empty($order)) {
            $data = [
                'pageTitle' => trans('public.cart_page_title'),
                'order' => $order,
            ];

            // SendOrderShippedMailJob::dispatch($order);

            return view('status_pay', $data);
        }

        abort(404);
    }
}
