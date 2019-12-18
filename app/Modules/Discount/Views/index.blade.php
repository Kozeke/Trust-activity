@extends('Panel::layouts/app')

@section('title', 'Referral program')
@section('description', 'Referral program')

@section('content')

	<div id="alert-emails" class="alert-notification"><div class="image"></div><p>{!! Helpers::translate('emails-sended', 'Emails sended') !!}</p></div>
	<div id="alert-notification" class="alert-notification"><div class="image"></div><p>{!! Helpers::translate('code-copied', 'Code copied') !!}</p></div>
	<div id="alert-transferred" class="alert-notification" style="width: 240px; height: 80px;"><div class="image"></div><p style="height: auto; width: 170px;">{!! Helpers::translate('money-has-been-transferred-to-account', 'Money has been transferred to account') !!}</p></div>
	<div id="alert-withdraw" class="alert-notification" style="width: 240px; height: 80px;"><div class="image"></div><p style="height: auto; width: 170px;">{!! Helpers::translate('withdraw-request-has-been-sent', 'Withdraw request has been sent') !!}</p></div>
	<div class="admin_header"> 
	    <div class="admin_title">
	        <h1>{!! Helpers::translate('referral-program', 'Referral program') !!}</h1>
	    </div>
	</div>
	<div class="admin_content">
	    <div class="container admin_container">
	        <div class="row">
	            <div class="col-lg-offset-2 col-lg-8">
	                <div class="affiliate_title">
	                    <h2>{!! Helpers::translate('invite-your-friends-and-get-cash-back', 'Invite your friends and get cash back') !!}</h2>
	                    <p>{!! Helpers::translate('receive-up-to-20-money-back-from-friends-purchases', 'Receive up to 20% money back from friend’s purchases') !!}.</p>
	                </div>
	            </div>
	        </div>
	        <div class="row">
	            <div class="col-lg-offset-2 col-lg-8">
	                <div class="friends_email_img"></div>
	                <div class="friends_dollar_img"></div>
	                <div class="friends_email">
	                    <div class="text_friends_email">{!! Helpers::translate('use-commas-to-separate-several-people', 'Use commas “ , ” to separate several people') !!}</div>
	                    <form>
	                        <div class="friends_email_form_row">
	                            <input type="text" name="send-to-friends" placeholder="{!! Helpers::translate('send-email-to-a-friend', 'Send email to a friend') !!}">
	                            <button id="email-to-friends">{!! Helpers::translate('send', 'Send') !!}</button>
	                        </div>	 
	                    </form> 
	                </div>
	            </div>
	        </div>
	        <div class="row">
	            <div class="col-lg-offset-2 col-lg-8">
	                <div class="friends_link_bonus">
	                    <div class="friends_link_bonus_title">{!! Helpers::translate('here-is-your-referral-link-you-can-copy-it-and-use-it-in-different-publications-comments-on-forums-social-media-posts-etc', 'Here is your referral link. You can copy it and use it in different publications, comments on forums, social media posts, etc.') !!}</div>
	                    <div class="link_bonus_box">
	                        <div class="link_bonus_text">
	                        	<input type="text" class="link_bonus_code" value="https://www.trustactivity.com/auth/register?referral_id={{ $user->id }}">
	                            <p class="copy_link_bonus" id="copy_link"></p>
	                        </div>
	                    </div>
	                </div>
	                <div class="friends_link_or">
	                    <p>{!! Helpers::translate('or', 'or') !!}</p>
	                </div>
	                <div class="friends_link_bonus_code">
	                    <div class="friends_link_bonus_title">{!! Helpers::translate('you-can-give-this-bonus-code-and-all-affiliates-will-get-10-after-sign-up-with-this-code', 'You can give this bonus code and all affiliates will get 10$ after sign up with this code') !!}</div>
	                    <div class="link_bonus_box">
	                        <div class="link_bonus_text">
	                        	<input type="text" class="link_bonus_code" value="{{ $user->discount->bonus_code }}">
	                            <p class="copy_link_bonus" id="copy_code"></p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="row">
	            <div class="col-lg-offset-2 col-lg-8">
	                <div class="affiliate_table_price">
	                    <div class="affiliate_table_item"> 
	                        <div class="affiliate_table_head">{!! Helpers::translate('total-referrals', 'Total referrals') !!}</div>
	                        <div class="affiliate_table_body">{{ $user->totalReferrals($user->id) }}</div>
	                    </div>
	                    <div class="affiliate_table_item">
	                        <div class="affiliate_table_head">{!! Helpers::translate('money-per-month', 'Money per month') !!}</div>
	                        <div class="affiliate_table_body">$0</div>
	                    </div>
	                    <div class="affiliate_table_item">
	                        <div class="affiliate_table_head">{!! Helpers::translate('total-money', 'Total money') !!}</div>
	                        <div class="affiliate_table_body">${{ $user->referral_balance_total }}</div>
	                    </div>
	                    <div class="affiliate_table_item">
	                        <div class="affiliate_table_head">{!! Helpers::translate('partnership-balance', 'Partnership balance') !!}</div>
	                        <div class="affiliate_table_body color_blue">
	                        	<span id="total_referral_money">${{ $user->referral_balance - $withdraw }}</span>
	                        	<span class="withdraw-summ">{!! Helpers::translate('withdrawal-amount', 'withdrawal amount') !!} 
	                        		<span id="withdraw_money">${{ $withdraw }}</span>
	                        	</span></div>
	                    </div>
	                </div>
	                <div class="transfer_money_block">
	                    <form>
	                        <div class="transfer_money_row">
	                            <div class="transfer_money_radio transfer_money_balance">
	                                <input type="radio" id="transfer_balance" value="transfer_balance" name="transfer_money" checked="checked">
	                                <label for="transfer_balance">{!! Helpers::translate('transfer-to-my-balance', 'Transfer to my balance') !!}</label>
	                            </div>
	                            <div class="transfer_money_radio transfer_money_withdraw">
	                                <input type="radio" id="transfer_withdraw" value="transfer_withdraw" name="transfer_money">
	                                <label for="transfer_withdraw">{!! Helpers::translate('withdraw-money', 'Withdraw money') !!}</label>
	                            </div>
	                        </div>
	                        <div class="transfer_money_row">
	                            <div class="count_transfer_money">
	                                <input type="number" id="operation-summ">
	                                <span class="dollar_input">$</span>
	                                <button class="btn_transfer_balance show" id="transfer-to-balance">{!! Helpers::translate('transfer', 'Transfer') !!}</button>
	                                <button class="btn_transfer_withdraw" id="withdraw-to-card">{!! Helpers::translate('withdraw', 'Withdraw') !!}</button>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	        <div class="row">
	            <div class="col-lg-offset-2 col-lg-8">
	                <div class="affiliate_history_block">
	                    <div class="affiliate_history_item referrals_information">
	                        <div class="affiliate_history_icon"></div>
	                        <div class="affiliate_history_desc">
	                            <div class="affiliate_history_name referrals_information_link">{!! Helpers::translate('referrals-information', 'Referrals information') !!}</div>
	                            <div class="affiliate_history_text">{!! Helpers::translate('track-all-you-friends-activity-and-check-commission-from-them', 'Track all you friends activity and check commission from them') !!}</div>
	                        </div> 
	                    </div>
	                    <div class="affiliate_history_item payment_history">
	                        <div class="affiliate_history_icon"></div>
	                        <div class="affiliate_history_desc">
	                            <div class="affiliate_history_name payment_history_link">{!! Helpers::translate('withdraw-history', 'Withdraw History') !!}</div>
	                            <div class="affiliate_history_text">{!! Helpers::translate('withdraw-date-withdraw-amount-withdraw-method-status', 'Withdraw date, Withdraw amount, Withdraw method, Status') !!}</div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

		<div class="referrals_information_block">
		    <div class="referrals_block_fon"></div>
		    <div class="c-referrals_block">
		        <div class="referrals_block_title">{!! Helpers::translate('referrals-information', 'Referrals information') !!}</div>
		        <div class="referrals_block_text">{!! Helpers::translate('see-all-friends-purchases', 'see all friend’s purchases') !!}</div>
		        <!--<div class="referrals_block_search">
		            <form>
		                <button class="referrals_search_icon"></button>
		                <input type="search" placeholder="Type to search...">
		            </form>
		        </div>-->
		        <div class="referrals_list_header">
		            <p>{!! Helpers::translate('invited-friends', 'Invited Friends') !!}</p>
		            <p>{!! Helpers::translate('total-payments', 'Total payments') !!}</p>
		            <p>{!! Helpers::translate('my-commissions', 'My commissions') !!}</p>
		        </div>
		        <div class="referrals_block_list">
		        	@foreach($r_history as $r_history_item)
		            <div class="referrals_list_item">
		                <p class="invited_friends_text"><a href=""><span></span>{{ $r_history_item->userEmail($r_history_item->referral_id) }}</a></p>
		                <p class="total_payments_text">$ {{ $r_history_item->total }}</p>
		                <p class="commissions_text">$ {{ $r_history_item->commission }}</p>
		            </div>
		            @endforeach
		        </div>
		    </div>
		</div>

		<div class="payment_history_block">
		    <div class="payment_block_fon"></div>
		    <div class="c-payment_block">
		        <div class="referrals_block_title">{!! Helpers::translate('withdraw-history', 'Withdraw History') !!}</div>
		        <div class="referrals_block_text">{!! Helpers::translate('see-all-account-transactions', 'see all account transactions') !!}</div>
		        <div class="payment_block_list_head">
		            <p class="payment_left">{!! Helpers::translate('day', 'Day') !!}</p>
		            <p class="payment_center">{!! Helpers::translate('amount', 'Amount') !!}</p>
		            <p class="payment_center">{!! Helpers::translate('method', 'Method') !!}</p>
		            <p class="payment_right">{!! Helpers::translate('status', 'Status') !!}</p>
		        </div>
		        <div class="payment_block_list">
		        	@foreach($history as $history_item)
			            <div class="payment_block_list_item">
			                <p class="payment_day payment_left">{{ $history_item->created }}</p>
			                <p class="payment_amount payment_center">$ {{ $history_item->summ }}</p>
                            @if ($history_item->type == 0)
			                	<p class="payment_method payment_center">{!! Helpers::translate('withdraw', 'Withdraw') !!}</p>
                            @elseif ($history_item->type == 1)
			                	<p class="payment_method payment_center">{!! Helpers::translate('balance', 'Balance') !!}</p>
                            @endif
                            @if ($history_item->status == 0)
                                <p class="payment_status payment_right payment_success" style="color: #f9dba8;">{!! Helpers::translate('pending', 'Pending') !!}</p>
                            @elseif ($history_item->status == 1)
                                <p class="payment_status payment_right payment_success">{!! Helpers::translate('accepted', 'Accepted') !!}</p>
                            @elseif ($history_item->status == 2)
                                <p class="payment_status payment_right payment_cancelled">{!! Helpers::translate('declined', 'Declined') !!}</p> 
                            @endif
			            </div>
		        	@endforeach
		        </div>
		    </div>
		</div>
	</div>

@endsection
