<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;

use Illuminate\Http\Request;

class RazorpayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('razorpay');
    }


    public function payment(Request $request)
    {
        $amount = $request->input('amount'); // amount in INR

        // Razorpay API instance
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Order data
        $orderData = [
            'receipt'         => 'order_' . rand(1000, 9999),
            'amount'          => $amount * 100, // amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        // Create order
        $order = $api->order->create($orderData);

        return view('payment', ['orderId' => $order['id'], 'amount' => $amount * 100]);
    }

    public function callback(Request $request)
    {
        $payId = $request->payId;
        $orderId = $request->orderId;
        $sign = $request->sign;

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $attr = [
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $payId,
                'sign' => $sign,
            ];

            $api->utility->verifyPaymentSignature($attr);

            echo "Payment Verified ".$payId;

        } catch (\Exception $e) {
            echo "Payment verification failed";
        }
    }
}
