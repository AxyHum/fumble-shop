<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function invoice(Request $request)
    {
        $order = Order::find($request->get('order_id'));

        if ($order) {
            $pdf = Pdf::loadView('emails.orders.shipped', ['order' => $order])->setOptions(['defaultFont' => 'MontSerrat', 'isRemoteEnabled' => true]);
            return $pdf->download('invoice.pdf');
        };
    }

    public function list(Request $request)
    {
        if ($request->get('pass') !== 'fumble') {
            abort(401);
        }
        $orders = Order::orderBy('id', 'desc')->paginate(50);

        return view('orders_list', compact('orders'));
    }
}
