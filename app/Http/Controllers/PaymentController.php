<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderPaymentTransaction;
use App\Models\WalletTransactionRefrance;
use Illuminate\Http\Request;
use App\Modules\Core\Helper;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use function Nette\Utils\first;

class PaymentController extends Controller {

    public function afterPayment(Request $request) {

        $reference = $request->route('reference');
        if (str_contains($reference, 'wallet')) {
            // @todo get payment_id for the reference
            $wallet_pay= WalletTransactionRefrance::where('referance_code',$reference)->first();
            $paymentIntentId = $wallet_pay['payment_intent'];//cs_test_a1AH2zOFX2XMP9DUBfJGzIEVmUlyNuSTIQ2F02lkR5PWnxkyM3Bqmd8cqd';
        }else{
            // @todo get payment_id for the reference
            $order_pay= OrderPaymentTransaction::where('order_id',$reference)->first();
            $paymentIntentId = $order_pay['payment_id'];//cs_test_a1AH2zOFX2XMP9DUBfJGzIEVmUlyNuSTIQ2F02lkR5PWnxkyM3Bqmd8cqd';

        }

        Stripe::setApiKey(config('stripe.secret_key'));
        $result = \Stripe\Checkout\Session::retrieve($paymentIntentId);

        // @todo make view for each case
        switch ($result->payment_status) {
            case 'paid':
                OrderPaymentTransaction::where('order_id',$reference)->update(['status'=>'paid']);
                return 'Success';
                break;
            case 'unpaid':
                OrderPaymentTransaction::where('order_id',$reference)->update(['status'=>'unpaid']);
                return 'Failed';
                break;
            default:
                return 'Complete';
        }
    }

}
