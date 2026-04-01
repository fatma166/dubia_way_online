<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Core\Helper;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller {

    public function afterPayment(Request $request) {
        $reference = $request->route('reference');

        // @todo get payment_id for the reference
        $paymentIntentId = 'cs_test_a1AH2zOFX2XMP9DUBfJGzIEVmUlyNuSTIQ2F02lkR5PWnxkyM3Bqmd8cqd';

        Stripe::setApiKey(config('stripe.secret_key'));
        $result = \Stripe\Checkout\Session::retrieve($paymentIntentId);

        // @todo make view for each case
        switch ($result->payment_status) {
            case 'paid':
                return 'Success';
                break;
            case 'unpaid':
                return 'Failed';
                break;
            default:
                return 'Complete';
        }
    }

}
