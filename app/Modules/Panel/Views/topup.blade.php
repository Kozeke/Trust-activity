@extends('Panel::layouts/app')

@section('title', 'Top Up Your Balance')
@section('description', 'Top Up Your Balance')

@section('content')
<div class="payout_modal_preloader"></div>
@if ($message = Session::get('success'))
    <div class="top_up_payment_modal show_modal">
        <div class="top_up_payment_modal_fon"></div>
        <div class="c-top_up_payment_modal">
            <div class="top_up_payment_modal_title">Payment successfully made!</div>

            <div class="top_up_payment_next">
                <a href="/admin/domains" style="margin: auto;">
                    <span>Got it!</span>
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <?php Session::forget('success');?>
    @endif
@if ($message = Session::get('error'))
    <div class="top_up_payment_modal show_modal">
        <div class="top_up_payment_modal_fon"></div>
        <div class="c-top_up_payment_modal">
            <div class="top_up_payment_modal_title">Error: {!! $message !!}</div>

            <div class="top_up_payment_next">
                <a href="/admin/domains" style="margin: auto;">
                    <span>Got it!</span>
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <?php Session::forget('error');?>
    @endif
    <div class="admin_header">
        <div class="admin_title domain_title">
            <h1>{!! Helpers::translate('top-up-your-balance', 'Top Up Your Balance') !!}</h1>
        </div>
    </div>

    <form method="POST" id="payment-form" action="/topup/pay">
      {{ csrf_field() }}
      <input name="payment-amount" type="text">   
      <input name="payment-type" type="text">  
      <input name="payment-bonus" type="text">   
      <input name="payment-method" type="text" value="paypal">   
      <button>Pay with PayPal</button>
    </form>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="topUp_block"> 
                        <div class="topUp_left"> 
                            <div class="topUp_title">{!! Helpers::translate('promotions-and-special-offers', 'Promotions and special offers!') !!}</div>
                            <div class="topUp_text">{!! Helpers::translate('do-you-like-our-service-we-are-grateful-to-you-for-your-trust-and-decided-to-please-you-with-regular-promotions-for-our-services', 'Do you like our service? We are grateful to you for your trust and decided to please you with regular promotions for our services.') !!}</div>
                            <div class="topUp_link">
                                <a id="bonus-mini"> 
                                    <p class="topUp_link_price">$50</p>
                                    <p class="topUp_link_text">{!! Helpers::translate('pay-50-and-get-extra-7-on-your-balance', 'Pay $50 and get extra $7 on your balance') !!} </p>     
                                    <p class="topUp_link_extra_text">{!! Helpers::translate('get-extra-7', 'Get extra $7') !!}</p>
                                </a>
                                <a id="bonus-max">
                                    <p class="topUp_link_price">$100</p>
                                    <p class="topUp_link_text">{!! Helpers::translate('pay-100-and-get-extra-20-on-your-balance', 'Pay $100 and get extra $20 on your balance') !!} </p>     
                                    <p class="topUp_link_extra_text">{!! Helpers::translate('get-extra-20', 'Get extra $20') !!}</p>
                                </a>
                            </div>
                        </div>
                        <div class="topUp_or"><p>{!! Helpers::translate('or', 'or') !!}</p></div>
                        <div class="topUp_right"> 
                            <div class="topUp_title">{!! Helpers::translate('you-can-pay-custom-amount', 'You can pay custom amount') !!}</div>
                            <div class="topUp_bonus_code" style="display: none;">
                                <div class="topUp_bonus_code_text">Do you have special promotion bonus code?</div>
                                <div class="topUp_bonus_code_toggle">
                                    <input type="checkbox" id="topUp_bonus_code">
                                    <label for="topUp_bonus_code">
                                        <span class="bonus_code_yes">YES</span>
                                        <span class="bonus_code_no">NO</span>
                                    </label>
                                </div>
                            </div>
                            <div class="topUp_bonus_input">
                                <input type="text" placeholder="Bonus Code" id="custom-bonus">
                            </div>
                            <div class="current_balance">
                                <p>{!! Helpers::translate('current-balance', 'Current balance') !!}:<span class="current_balance_text">$ {{ Auth::user()->balance }}</span></p>
                            </div>
                            <div class="topUp_balance_input">
                                <form>
                                    <input type="number" id="custom-amount">
                                    <span class="dollar_input">$</span>
                                    <button>{!! Helpers::translate('top-up', 'Top Up') !!}</button>
                                </form>
                            </div>
                        </div>
                    </div> 
                    <div class="topUp_caption_text">{!! Helpers::translate('the-top-up-discount-applies-to-the-price-for-all-paid-tools-in-trustactivity-like-promotion-jumpout-and-emails', 'The top up discount applies to the price for all paid tools in TrustActivity, like Promotion, JumpOut and Emails.') !!}</div>
                    <div class="topUp_payments_block"> 
                        <div class="topUp_payments_text">{!! Helpers::translate('all-payments-are-accepted-via-one-of-the-leaders-in-e-commerce-the-service-2checkout-if-you-cant-find-the-appropriate-method-of-payment-please-contact-our', 'All payments are accepted via one of the leaders in e-commerce – the service 2Checkout. If you can’t find the appropriate method of payment, please, contact our') !!} 
                            <a href="mailto:support@trustactivity.com" >{!! Helpers::translate('support-team', 'support team') !!}</a>.</div>
                        <div class="Checkout">
                            <div class="Checkout_icon"></div>
                        </div>
                        <div class="topUp_payments_icon">
                            <div class="topUp_payments_icon_left">
                                <div class="gopay"></div>
                                <div class="visa"></div>
                                <div class="visa_electron"></div>
                                <div class="mc"></div>
                                <div class="mc_electron"></div>
                                <div class="maestro"></div>
                            </div>
                            <div class="topUp_payments_icon_right">
                                <div class="pp"></div>
                                <div class="verified_visa"></div>
                                <div class="mc_securecode"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <topuppurchase></topuppurchase>


    <div class="top_up_payment_modal">
        <div class="top_up_payment_modal_fon"></div>
        <div class="c-top_up_payment_modal">     
            <div class="top_up_payment_modal_title">{!! Helpers::translate('select-payment-method', 'Select payment method') !!}</div>
            <div class="top_up_payment_block">
                <div class="top_up_payment_item top_up_payment_paypal active" data-method="paypal"> 
                    <p></p>
                </div>
                <div class="top_up_payment_item top_up_payment_2checkout" data-method="2checkout">
                    <p></p>
                </div>
            </div>
            <div class="top_up_payment_next">
                <a href="" id="send-payment">
                    <span>{!! Helpers::translate('check-out', 'Check Out') !!}</span>
                    <span></span>
                </a>
            </div>
        </div>
	    <div id="checkout-form">
            <form id="myCCForm" action="http://dev.positron-it.ru/admin/2checkout" method="post">
              <input name="token" type="hidden" value="" />
              <div>
                <label>
                  <span>Name</span>
                  <input id="name" type="text" name="name" value="" autocomplete="off" required />
                </label>
              </div>
              <div>
                <label>
                  <span>Address</span>
                  <input id="addrLine1" type="text" name="addrLine1" value="" autocomplete="off" required />
                </label>
              </div>
              <div>
                <label>
                  <span>City</span>
                  <input id="city" type="text" name="city" value="" autocomplete="off" required />
                </label>
              </div>
              <div>
                <label>
                  <span>State</span>
                  <input id="state" type="text" name="state" value="" autocomplete="off" required />
                </label>
              </div>
              <div>
                <label>
                  <span>Zip code</span>
                  <input id="zipCode" type="text" name="zipCode" value="" autocomplete="off" required />
                </label>
              </div>
              <div>
                <label>
                  <span>Country</span>
                  <input id="country" type="text" name="country" value="" autocomplete="off" required />
                </label>
              </div>
              <div>
                <label>
                  <span>Phone number</span>
                  <input id="phoneNumber" type="text" name="phoneNumber" value="" autocomplete="off" required />
                </label>
              </div>
              <div class="chk-card-data">
                  <div>
                    <label>
                      <span>Card Number</span>
                      <input id="ccNo" type="text" value="" autocomplete="off" required />
                    </label>
                  </div>
                  <div>
                    <label>
                      <span>Expiration Date (MM/YYYY)</span>
                      <input id="expMonth" type="text" size="2" required />
                    </label>
                    <span> / </span>
                    <input id="expYear" type="text" size="4" required />
                  </div>
                  <div>
                    <label>
                      <span>CVC</span>
                      <input id="cvv" type="text" value="" autocomplete="off" required />
                    </label>
                  </div>
              </div>
              <input type="submit" value="Submit Payment" />
            </form>
            <div class="domain_modal_preloader"></div>
	    </div>
    </div>
 

@endsection

 