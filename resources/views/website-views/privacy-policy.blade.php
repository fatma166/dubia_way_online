@extends('layouts.website.master')

@section('title', __('Privacy & Return Policy'))

@push('style')
<style>

.privacy-policy-container{
    max-width:900px;
    margin:40px auto;
    padding:40px;
    background:#fff;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

/* Header */

.policy-header{
    text-align:center;
    margin-bottom:35px;
}

.policy-header h1{
    font-size:32px;
    color:#232323;
    margin-bottom:10px;
}

.policy-header span{
    display:inline-block;
    width:60px;
    height:4px;
    background:#bfa15a;
    border-radius:10px;
}

/* intro box */

.policy-intro{
    background:linear-gradient(135deg,#faf7ef,#ffffff);
    border:1px solid #eee;
    border-radius:12px;
    padding:25px;
    margin-bottom:30px;
    text-align:center;
}

.policy-intro i{
    font-size:32px;
    color:#bfa15a;
    margin-bottom:10px;
}

.policy-intro h2{
    font-size:22px;
    margin-bottom:10px;
    color:#232323;
}

.policy-intro p{
    color:#666;
    font-size:15px;
}

/* trust icons */

.trust-box{
    display:flex;
    justify-content:space-between;
    gap:15px;
    margin-bottom:35px;
    flex-wrap:wrap;
}

.trust-item{
    flex:1;
    min-width:160px;
    text-align:center;
    background:#fafafa;
    padding:18px;
    border-radius:10px;
    border:1px solid #eee;
}

.trust-item i{
    font-size:22px;
    color:#bfa15a;
    margin-bottom:8px;
}

.trust-item p{
    margin:0;
    font-size:14px;
    color:#444;
}

/* list */

.policy-list{
    list-style:none;
    padding:0;
}

.policy-list li{
    background:#fafafa;
    margin-bottom:12px;
    padding:14px 16px;
    border-radius:8px;
    display:flex;
    align-items:flex-start;
    gap:10px;
    font-size:15px;
    color:#555;
    border:1px solid #eee;
}

.policy-list li i{
    color:#bfa15a;
    font-size:16px;
    margin-top:3px;
}

/* mobile */

@media(max-width:768px){

    .privacy-policy-container{
        padding:25px;
        margin:20px;
    }

    .policy-header h1{
        font-size:26px;
    }

    .trust-box{
        flex-direction:column;
    }

}

</style>
@endpush


@section('content')

<div class="privacy-policy-container">

    <div class="policy-header">
        <h1>{{__('Privacy & Return Policy')}}</h1>
        <span></span>
    </div>


    <div class="policy-intro">

        <i class="fa fa-shield-alt"></i>

        <h2>{{__('Easy Return & Customer Satisfaction')}}</h2>

        <p>
            {{__('Our goal is customer satisfaction first, so we strive to make the return and exchange process easy.')}}
        </p>

    </div>


    <div class="trust-box">

        <div class="trust-item">
            <i class="fa fa-truck"></i>
            <p>{{__('Free Shipping')}}</p>
        </div>

        <div class="trust-item">
            <i class="fa fa-money-bill-wave"></i>
            <p>{{__('Cash on Delivery')}}</p>
        </div>

        <div class="trust-item">
            <i class="fa fa-undo"></i>
            <p>{{__('Easy Returns')}}</p>
        </div>

    </div>


    <ul class="policy-list">

        <li>
            <i class="fa fa-check-circle"></i>
            {{__('The product can be returned or exchanged within 3 days from the date of delivery.')}}
        </li>

        <li>
            <i class="fa fa-check-circle"></i>
            {{__('The product must be in its original condition and unused with all accessories and packaging.')}}
        </li>

        <li>
            <i class="fa fa-check-circle"></i>
            {{__('If there is a defect in the product or an order mistake, the store will bear the shipping cost.')}}
        </li>

        <li>
            <i class="fa fa-check-circle"></i>
            {{__('If the customer changes their mind, the customer will bear the shipping cost for exchange or return.')}}
        </li>

        <li>
            <i class="fa fa-check-circle"></i>
            {{__('Returned products are inspected before completing the return or exchange process.')}}
        </li>

        <li>
            <i class="fa fa-check-circle"></i>
            {{__('Refunds are processed within 3 to 7 business days after receiving and inspecting the product.')}}
        </li>

        <li>
            <i class="fa fa-check-circle"></i>
            {{__('Used products or products damaged due to misuse cannot be returned.')}}
        </li>

        <li>
            <i class="fa fa-check-circle"></i>
            {{__('You can contact customer service via WhatsApp or the Contact Us page to request a return or exchange.')}}
        </li>

    </ul>

</div>

@endsection