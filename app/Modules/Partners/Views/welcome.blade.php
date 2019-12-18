@extends('Panel::layouts/app')

@section('title', 'Partner cabinet')
@section('description', 'Partner cabinet')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>{!! Helpers::translate('partner-program', 'Partner program') !!}</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8 partner-block"> 
                    <div class="guide_step_title">
                        <h2>{!! Helpers::translate('become-a-part-of-our-partner-program', 'Become a part of our Partner Program') !!}</h2> 
                    </div>
                    <div class="guide_step_desc">
                        <h2>{!! Helpers::translate('for-agencies-and-freelance-marketers', 'For agencies and freelance marketers') !!}</h2>
                        <p>{!! Helpers::translate('if-you-are-an-agency-or-a-marketer-freelancer-who-wants-to-make-money-with-us-and-have-access-to-the-accounts-of-all-of-your-clients-just-send-us-a-request-and-we-will-make-you-part-of-our-partner-program', 'If you are an agency or a marketer-freelancer who wants to make money with us and have access to the accounts of all of your clients, just send us a request and we will make you part of our  Partner Program!👇') !!}</p>
                        @if($status)
                            <p>{!! Helpers::translate('admin-checking-your-request-please-stand-by', 'Admin checking your request. Please stand by.') !!}</p>
                        @else 
                            <button class="btn btn_fon" id="partner-request" data-message="{!! Helpers::translate('admin-checking-your-request-please-stand-by', 'Admin checking your request. Please stand by.') !!}"><span>{!! Helpers::translate('send-request', 'Send Request') !!}</span></button>
                        @endif
                    </div>
 
                </div>
            </div>

        </div>
    </div>
 
@endsection
