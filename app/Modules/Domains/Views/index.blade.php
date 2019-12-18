@extends('Panel::layouts/app')

@section('title', 'Domains')
@section('description', 'Domains')

@section('content')
    @if (Session::get('success'))
        <div class="top_up_payment_modal show_modal">
            <div class="top_up_payment_modal_fon"></div>
            <div class="c-top_up_payment_modal">
                <div class="top_up_payment_modal_title">{!! Helpers::translate('payment-successfully-made', 'Payment successfully made!') !!}</div>

                <div class="top_up_payment_next">
                    <a href="/admin/domains" style="margin: auto;">
                        <span>{!! Helpers::translate('got-it', 'Got it!') !!}</span>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    <?php Session::forget('success');?>
    @endif
    @if (Session::get('error'))
        <div class="top_up_payment_modal show_modal">
            <div class="top_up_payment_modal_fon"></div>
            <div class="c-top_up_payment_modal">
                <div class="top_up_payment_modal_title">{!! Helpers::translate('payment-failed', 'Payment failed!') !!}</div>
                <div class="top_up_payment_next">
                    <a href="/admin/domains" style="margin: auto;">
                        <span>{!! Helpers::translate('got-it', 'Got it!') !!}</span>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    <?php Session::forget('error');?>
    @endif

    <div class="admin_header">
        <div class="admin_title">
            <h1>{!! Helpers::translate('domains-list', 'Domains List') !!}</h1>
        </div>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="domain_list_search">
                        <!--<form>
                            <button></button>
                            <input type="search" placeholder="Type to search...">
                        </form>-->
                    </div>
                </div>
            </div>
            <div class="row">
            @foreach($list as $domain_el)
                    <div class="col-lg-5 domain_list_block">
                        <div class="domain_list_item">
                            <div class="domain_list_head">
                                <div class="domain_list_title">
                                    <a href="/admin/domains/{{ $domain_el->id }}">
                                        @if ($domain_el->isActive)
                                            <span class="domain_icon">
                                                <img src="https://www.google.com/s2/favicons?domain={{ $domain_el->url }}" alt="{{ $domain_el->name }}">
                                            </span>
                                            <span class="domain_name">{{ $domain_el->url }}</span>
                                        @else
                                            <span class="domain_icon"><img src="/img/uninstalled.svg" alt=""></span>
                                            <span class="domain_name unactive">{{ $domain_el->url }}</span>
                                        @endif
                                    </a>
                                </div>
                                <div class="domain_connect">
                                    @if ($domain_el->isActive)
                                        <p>{!! Helpers::translate('connected', 'connected') !!}: <span>{{ $domain_el->created }}</span></p>
                                    @else
                                        <p>{!! Helpers::translate('not-connected', 'Not connected') !!}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="domain_list_body">
                                <?php  $purchase_status = $domain_el->getActivePurchaseStatus($domain_el->id); ?>
                                @if($purchase_status == 2)
                                    <div class="domain_campaign_item domain_campaign_notification unactive">
                                @else
                                    <div class="domain_campaign_item domain_campaign_notification">
                                @endif
                                    <div class="domain_campaign_title">
                                        <div class="domain_campaign_name">
                                            <span></span>
                                            <span>{!! Helpers::translate('notifications', 'Notifications') !!}</span>
                                        </div>
										<div class="domain_campaign_rate">
                                            <p>{{ $domain_el->purchases($domain_el->id, 'name') }}</p>
                                        </div>
                                        <div class="domain_campaign_subscription">
										@if ($domain_el->purchases($domain_el->id, 'name') == '')
										    <p class="no_subscription" style="display: block;">{!! Helpers::translate('no-subscription', 'no subscription') !!}</p>
										@else  
										    <p class="date_subscription">{!! Helpers::translate('up-to', 'up to') !!} {{ $domain_el->purchases($domain_el->id, 'till') }}</p>
										@endif
                                        </div>
                                    </div>
                                    @if ($domain_el->purchases($domain_el->id, 'name') != '')
                                        <div class="domain_notification_progressbar" id="notification_progressbar_corporate">
                                            <div class="all_progressbar">
                                                <?php  $percent = $domain_el->purchaseProgressStatus($domain_el->id); ?>
                                                @if($percent < 50)
                                                    <div class="value_progressbar" style="width: {{ $percent }}%"></div>
                                                @elseif($percent > 50 && $percent < 70)
                                                    <div class="value_progressbar orange" style="width: {{ $percent }}%"></div>
                                                @elseif($percent > 70)
                                                    <div class="value_progressbar red" style="width: {{ $percent }}%"></div>
                                                @endif
                                                <?php echo $percent;?>
                                            </div> 
                                                <div class="progressbar_tracked">
                                                    <p class="progressbar_tracked_value">{{ $domain_el->purchaseVisitors($domain_el->id) }}</p>
                                                    <p>{!! Helpers::translate('unique-visitors-tracked', 'Unique Visitors Tracked') !!}</p>
                                                </div>
                                                <div class="progressbar_allowed">
                                                    <p class="progressbar_allowed_value">{{ $domain_el->purchaseLimit($domain_el->id) }}</p>
                                                    <p>{!! Helpers::translate('unique-visitors-allowed', 'Unique Visitors Allowed') !!}</p>
                                                </div>
                                        </div>
                                    @else

                                    @endif  
                                </div> 
                                @if($purchase_status == 2)
                                    <p class="nolimit-warning">{!! Helpers::translate('you-have-reached-traffic-limits', 'You have reached traffic limits! Please, activate next package with more limits') !!}.<a href="/admin/dashboard">{!! Helpers::translate('update-plan', 'Update plan') !!}.</a></p>
                                @endif
                            </div>
                            <div class="domain_list_operations">
                                <a href="#" class="domain_list_delete" data-id="{{ $domain_el->id }}">
                                    <span></span>
                                    <span>{!! Helpers::translate('delete', 'Delete') !!}</span>
                                </a>
                            </div>
                            @if($domain_el->deleted_at != NULL)
                                <div class="domain_deleted" style="display: block;">
                                    {!! Helpers::translate('domain-deleted', 'Domain deleted') !!}. <a href="#" class="undelete_domain" data-id="{{ $domain_el->id }}">{!! Helpers::translate('undo', 'Undo') !!}</a><br>
                                    <p>{!! Helpers::translate('the-domain-will-be-fully-deleted-from-our-database-after', 'The domain will be fully deleted from our database after') !!} {{ $domain_el->deleted_left }} {!! Helpers::translate('hours', 'hours') !!}. {!! Helpers::translate('please-press-undo-if-you-want-to-restore-this-domain-or-all-data-will-be-deleted-permanently', 'Please, press "Undo" if you want to restore this domain or all data will be deleted permanently') !!}.</p>
                                </div>
                            @endif
                        </div>
                    </div>
            @endforeach
            </div>
        </div>
    </div>

@endsection
