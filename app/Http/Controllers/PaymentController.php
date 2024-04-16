<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function purchase(String $product, $price)
    {
        // $customer = Customer::findOrFail($customerId);
        return view('payment', [
            /* 'customer' => $customer, */
            /* 'intent' => $customer->createSetupIntent(), */
            'product' => $product,
            'price' => $price
        ]);
    }
    public function processPayment(Request $request, String $product, $price)
    {
        //         You may also use the charge method without an underlying customer or user. To accomplish this, invoke the charge method on a new instance of your application's billable model:
        // use App\Models\User;
        // $stripeCharge = (new User)->charge(100, $paymentMethod);


        // $user = Auth::user();
        $paymentMethod = $request->input('payment_method');
        $customer = new Customer;
        $customer->createOrGetStripeCustomer();
        $customer->addPaymentMethod($paymentMethod);
        // try {
        //     $user->charge($price * 100, $paymentMethod);
        // } catch (\Exception $e) {
        //     return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        // }
        try {
            $customer->charge($price * 100, $paymentMethod);
        } catch (Exception $e) {
            return back()->withErrors(['message' => 'Error creating subscription or something else. ' . $e->getMessage()]);
        }
        return redirect('home');
    }
}
