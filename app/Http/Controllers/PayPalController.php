<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    protected $provider;

    public function __construct(PayPalClient $provider)
    {
        $this->provider = $provider;
    }

    // Step 1: User clicks "Pay Now" button

      public function createPayment(Request $request)
      {
          // Initialize PayPal service
          $provider = new PayPalClient;

          // Set up the payment data
          $data = [
              'intent' => 'CAPTURE',  // You can use 'SALE' for immediate capture, or 'AUTHORIZATION' for later capture
              'purchase_units' => [
                  [
                      'amount' => [
                          'currency_code' => 'USD',  // Currency code
                          'value' => 100.00,         // Payment amount
                      ],
                  ],
              ],
              'application_context' => [
                  'return_url' => route('paypal.success'),  // Success URL after payment
                  'cancel_url' => route('paypal.cancel'),   // Cancel URL if payment is canceled
              ],
          ];

          // Create the order
          $response = $provider->createOrder($data);

          // Check if the response is successful and contains an ID
          if (isset($response['id'])) {
              // Redirect to PayPal for approval
              return redirect($provider->getApprovalLink($response['id']));
          } else {
              // Handle error (e.g., logging the error message or showing an error page)
              dd("error");
              return redirect()->route('paypal.error');
          }
      }

    // Step 3: User successfully pays (PayPal redirects here)
    public function paymentSuccess(Request $request)
    {
        // Get the payment details from PayPal
        $response = $this->provider->getExpressCheckoutDetails($request->token);

        // Process the payment here (e.g., save payment status, update order status)
        if ($response['ACK'] == 'Success') {
            // Execute the payment after user approves
            $paymentData = [
                'PAYERID' => $request->PayerID,
                'token' => $request->token,
            ];

            $paymentExecution = $this->provider->doExpressCheckoutPayment($paymentData);

            if ($paymentExecution['ACK'] == 'Success') {
                // Payment successful
                return redirect()->route('order.success')->with('message', 'Payment successful!');
            }
        }

        // If something goes wrong during payment execution
        return redirect()->route('order.failed')->with('error', 'Payment failed!');
    }

    // Step 4: User cancels the payment
    public function paymentCancel()
    {
        return redirect()->route('order.failed')->with('error', 'Payment was canceled.');
    }

    // Error page for payment failure
    public function paymentError()
    {
        return view('paypal.error');
    }
}
