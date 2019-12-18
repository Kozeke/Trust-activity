@extends('Panel::layouts/app')

@section('title', 'Partner cabinet')
@section('description', 'Partner cabinet')

@section('content')

    <div id="alert-emails" class="alert-notification"><div class="image"></div><p>{!! Helpers::translate('emails-sended', 'Emails sended') !!}</p></div>
    <div id="alert-notification" class="alert-notification"><div class="image"></div><p>{!! Helpers::translate('code-copied', 'Code copied') !!}</p></div>

    <div class="admin_header">
        <div class="admin_title">
            <h1>{!! Helpers::translate('partner-dashboard', 'Partner dashboard') !!}</h1>
        </div> 
    </div> 
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/partners" class="breadcrumbs_link">{!! Helpers::translate('partner-dashboard', 'Partner dashboard') !!}</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8">
                    <div class="friends_link_bonus">
                        <div class="link_bonus_box">
                            <div class="link_bonus_text">
                                <input type="text" class="link_bonus_code" value="https://www.trustactivity.com/auth/register?referral_id={{ $user->id }}">
                                <p class="copy_link_bonus" id="copy_link"></p>
                            </div>
                        </div>
                    </div>
                    <div class="friends_link_or" style="height: 45px;">
                        <p>{!! Helpers::translate('or', 'or') !!}</p>
                    </div>
                    <div class="friends_link_bonus_code">
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
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="notification_tabs">
                        <div class="notification_tabs_content active partners-tab">
                            <h2>{!! Helpers::translate('see-all-your-partners-progress', 'See all your partners progress') !!}</h2> 
                            <div class="payment_block_list_head partners">
                                <p class="payment_left">{!! Helpers::translate('partner', 'Partner') !!}</p>
                                <p class="payment_center">{!! Helpers::translate('registered', 'Registered') !!}</p>
                                <p class="payment_center">{!! Helpers::translate('balance-2', 'Balance') !!}</p>
                                <p class="payment_center">{!! Helpers::translate('websites', 'Websites') !!}</p>
                                <p class="payment_right"></p>
                            </div>
                            <div class="payment_block_list partners">
                                @foreach($users as $user)
                                    <div class="payment_block_list_item">
                                        <p class="payment_day payment_left">{{ $user->email }}</p>
                                        <p class="payment_amount payment_center">{{ $user->created }}</p>
                                        <p class="payment_amount payment_center">{{ $user->balance }}</p>
                                        <p class="payment_amount payment_center"><?=count($user->userDomains($user->id));?></p>                                       
                                        <p class="payment_status payment_right payment_cancelled">
                                            <a href="/admin/partners/enter/{{ $user->id }}" class="notification_settings_link contacts_link">
                                                <span class="notification_settings_icon"></span><span>{!! Helpers::translate('enter-as-user', 'Enter as user') !!}</span>
                                            </a>
                                        </p> 
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection
