<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderShippedMail;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function paymentVerify(Request $request)
    {
        $data = $request->all();
        $status = $data['status'];
        $order_id = $data['order_id'];

        $order = Order::find($order_id);

        if (!empty($order)) {
            $order->update(['status' => 'fail']);
        }

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

                return redirect('/payments/status?order_id=' . $order->id);
            }
        }

        if ($status == 'cancel') {
            $order->update(['status' => 'fail']);

            return redirect('/');
        }
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

            SendOrderShippedMailJob::dispatch($order);

            return view('status_pay', $data);
        }

        abort(404);
    }
}
