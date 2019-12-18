@extends('Panel::layouts/app')

@section('title', Helpers::translate('guide', 'Guide'))
@section('description', Helpers::translate('guide', 'Guide'))

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>{{ Helpers::translate('welcome-to-trust-activity', 'Welcome to Trust Activity') }}</h1>
        </div> 
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8">
                    <div class="guide_title"> 
                        <h2>{{ Helpers::translate('how-to-start-using-trust-activity', 'How to Start Using Trust Activity') }}</h2>
                        <p>{{ Helpers::translate('quick-guide', 'Quick Guide') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8">
                    <div class="guide_link">
                        <a href="/admin/guide-step-1">
                            <div class="guide_link_title">Step 1: Add Domain and Install the Pixel</div>
                            <div class="guide_link_text">Learn how to add domain in the system and install TrustActivity pixel on it.</div>
                            <div class="guide_link_arrow">
                                <svg width="9" height="18" viewBox="0 0 9 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.21955 9.89109L1.78807 17.6306C1.37895 18.1231 0.715637 18.1231 0.306716 17.6306C-0.102239 17.1384 -0.102239 16.3402 0.306716 15.8481L5.99758 8.99987L0.306881 2.15186C-0.102073 1.65952 -0.102073 0.861394 0.306881 0.369254C0.715835 -0.123085 1.37912 -0.123085 1.78824 0.369254L8.21972 8.10885C8.42419 8.35504 8.52632 8.67735 8.52632 8.99983C8.52632 9.32247 8.42399 9.64502 8.21955 9.89109Z" transform="translate(0 18) scale(1 -1)" />
                                </svg>
                            </div>
                        </a>
                    </div>
                    <div class="guide_link">
                        <a href="/admin/guide-step-2">
                            <div class="guide_link_title">Step 2: Launch New Campaign</div>
                            <div class="guide_link_text">Learn how easily and safely you can launch new campaign.</div>
                            <div class="guide_link_arrow">
                                <svg width="9" height="18" viewBox="0 0 9 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.21955 9.89109L1.78807 17.6306C1.37895 18.1231 0.715637 18.1231 0.306716 17.6306C-0.102239 17.1384 -0.102239 16.3402 0.306716 15.8481L5.99758 8.99987L0.306881 2.15186C-0.102073 1.65952 -0.102073 0.861394 0.306881 0.369254C0.715835 -0.123085 1.37912 -0.123085 1.78824 0.369254L8.21972 8.10885C8.42419 8.35504 8.52632 8.67735 8.52632 8.99983C8.52632 9.32247 8.42399 9.64502 8.21955 9.89109Z" transform="translate(0 18) scale(1 -1)" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection
