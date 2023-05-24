<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
}
