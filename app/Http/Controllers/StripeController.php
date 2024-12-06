<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    //

    public function checkout()
    {
        return view('checkout');
    }

    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $productname = 'Total price';

        $even = Event::findOrFail($request->eventid);

        $totalprice = $even->ticket_price;

        $parts = explode('.', $totalprice);

      // Get the part before the dot
        $wholeNumber = $parts[0];

        $total = "$wholeNumber";

        session(['id' => $request->get('eventid')]);

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => $productname,
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            'cancel_url'  => route('checkout'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {

        $id = session('id');

        return redirect()->route('booking-event', ['id' => $id]);

    }



}
