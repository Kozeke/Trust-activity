<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="viewport" content="width=1440">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/css/panel.css">
    <link rel="stylesheet" type="text/css" href="/css/jumpout.min.css">

    <link href="https://fonts.googleapis.com/css?family=Itim" rel="stylesheet">
    <script src="/js/panel.js" type="text/javascript"></script>
 
    <script type="text/javascript">
        
        /*(function($) {
        $(function() {

            if ($('#timezone').length > 0) {
                $('#timezone').styler();      
                $('.timezone-block').css('opacity', 1);    

                $('#timezone').on('change', function() {

                    var selected = $( "#timezone option:selected" ).val();
                    var data = {    
                        'selected' : selected,
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                    };
                    $.ajax({
                        type: "POST",
                        url: '/api/user/timezone',
                        data: data,
                        success: function(result) {
                        }
                    });   
                });     
            }
 
        });

        })(jQuery);    */        
   
    </script>
</head>
<body>
    @if (Session::get('admin_id'))
        <a class="admin-login" href="/admin/users/enter/admin">Вернуться под админа</a>
    @elseif (Session::get('partner_id')) 
        <a class="admin-login" href="/admin/partners/enter/partner">{!! Helpers::translate('return-to-my-account', 'Return to my account') !!}</a>
    @endif
    <div class="sidebar scrollbar-macosx">
        <div class="sidebar_logo">
            <a href="/"></a>
        </div>
        <div class="lang-block"><a href="/admin/change-lang/ru">ru</a> | <a href="/admin/change-lang/en">en</a></div>
        <div class="sidebar_user">
            <div class="sidebar_user_icon"></div>
            <div class="sidebar_user_email">{{ Auth::user()->email }}</div>
            <div class="sidebar_user_settings">
                <p class="sidebar_user_balance"><span>{!! Helpers::translate('balance', 'balance') !!}:</span> <span>${{ Auth::user()->balance }}</span></p>
                <a href="/admin/top-up" class="user_balance_up"><span>{!! Helpers::translate('top-up', 'Top up') !!}</span><span></span></a>
            </div>
        </div>
        <div class="sidebar_content">
            <div class="sidebar_item"> 
                <div class="sidebar_title">{!! Helpers::translate('welcome', 'Welcome') !!}</div>
                <ul>
                    <li><a href="/admin/guide" class="sidebar_link{{ Request::path() == 'admin/guide' ? ' active' : '' }}">
                        <span class="sidebar_icon sidebar_guide"></span>
                        <span>{!! Helpers::translate('guide', 'Guide') !!}</span>
                    </a></li>
                    <li><a href="/admin/video-instruction" class="sidebar_link{{ Request::path() == 'admin/video-instruction' ? ' active' : '' }}">
                        <span class="sidebar_icon sidebar_guide"></span>
                        <span>{!! Helpers::translate('video-instruction', 'Video Instruction') !!}</span>
                    </a></li>                  
                </ul>
            </div>
            <div class="sidebar_item">
                <div class="sidebar_title">{!! Helpers::translate('domains', 'Domains') !!}</div>
                <div class="add_domain">
                    <button class="btn btn_fon">
                        <span></span>
                        <span>{!! Helpers::translate('new-domain', 'New Domain') !!}</span>
                    </button>
                </div>
                <div class="all_domain">
                    @if(count($domains) > 0)
                        <a href="/admin/domains">{!! Helpers::translate('view-all-my-domains', 'View All My Domains') !!}<span></span></a>
                    @endif
                </div>
                <div class="domain_link_item">
                    <ul>
                    @foreach($domains as $domain_item)
                        <li>
                            <a href="/admin/domains/{{ $domain_item->id }}" class="domain_link {{ isset($domain) && $domain->id == $domain_item->id ? 'active' : '' }}"  >
                                @if($domain_item->isActive)
                                    <span class="domain_icon"><img src="https://www.google.com/s2/favicons?domain={{ $domain_item->url }}" alt=""></span>
                                @else
                                    <span class="domain_icon"><img src="/img/uninstalled.svg" alt=""></span>
                                @endif
                                <span>{{ $domain_item->name }}</span>
                            </a>
                        </li>
                    @endforeach   
                    </ul>
                </div>
            </div>
            <div class="sidebar_item">
                <div class="sidebar_title">{!! Helpers::translate('billing', 'Billing') !!}</div>
                <ul>
                    <li><a href="/admin/dashboard" class="sidebar_link{{ Request::path() == 'admin/dashboard' ? ' active' : '' }}">
                        <span class="sidebar_icon sidebar_dashboard"></span>
                        <span>{!! Helpers::translate('dashboard', 'Dashboard') !!}</span>
                    </a></li>
                    <!--<li><a href="/admin/settings" class="sidebar_link"><span class="sidebar_icon sidebar_setting"></span><span>Setting</span></a></li>-->
                    <li><a href="/admin/invoices" class="sidebar_link{{ Request::path() == 'admin/invoices' ? ' active' : '' }}"><span class="sidebar_icon sidebar_invoices"></span><span>{!! Helpers::translate('invoices', 'Invoices') !!}</span></a></li>
                    <li><a href="/admin/discount" class="sidebar_link{{ Request::path() == 'admin/discount' ? ' active' : '' }}">
                        <span class="sidebar_icon sidebar_affiliate"></span><span>{!! Helpers::translate('affiliate', 'Affiliate') !!}</span>
                    </a></li>
                    @if(Auth::user()->role == 2)
                        <li><a href="/admin/partners" class="sidebar_link{{ Request::path() == 'admin/partners' ? ' active' : '' }}">
                            <span class="sidebar_icon sidebar_affiliate"></span><span>{!! Helpers::translate('partner-program', 'Partner dashboard') !!}</span>
                        </a></li>
                    @else     
                        <li><a href="/admin/partners" class="sidebar_link{{ Request::path() == 'admin/partners' ? ' active' : '' }}">
                            <span class="sidebar_icon sidebar_affiliate"></span><span>{!! Helpers::translate('partner-program', 'Partner program') !!}</span>
                        </a></li>
                    @endif
                </ul>
            </div>
            <div class="sidebar_item">
                <div class="sidebar_title">{!! Helpers::translate('support', 'Support') !!}</div>
                <ul>
                    <!--<li><a href="/admin/resolution-center" class="sidebar_link{{ Request::path() == 'admin/resolution-center' ? ' active' : '' }}"><span class="sidebar_icon sidebar_resolution"></span><span>Resolution center</span></a></li>-->
                    <li><a href="mailto:support@trustactivity.com" class="sidebar_link">
                        <span class="sidebar_icon sidebar_resolution"></span>
                        <span>{!! Helpers::translate('contact-us', 'Contact us') !!}</span>
                    </a></li>
                    <li><a href="/admin/faq" class="sidebar_link{{ Request::path() == 'admin/faq' ? ' active' : '' }}">
                        <span class="sidebar_icon sidebar_faq"></span>
                        <span>{!! Helpers::translate('faq', 'FAQ') !!}</span>
                    </a></li>
                </ul>
            </div>
        </div>
        <div class="sidebar_footer visible-h">
            <a href="/auth/logout">
                <span>{!! Helpers::translate('logout', 'Logout') !!}</span>
                <span>
                   <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 17 14" style="enable-background:new 0 0 17 14;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:#FFFFFF;}
                        </style>
                        <path class="st0" id="arrow" d="M14.3,6.2H5C4.6,6.2,4.3,6.6,4.3,7c0,0.4,0.4,0.8,0.8,0.8h9.2l-1,1c-0.3,0.3-0.3,0.8,0,1.1
                            c0.3,0.3,0.8,0.3,1.1,0l2.4-2.3c0,0,0,0,0.1-0.1c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                            c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0-0.1,0-0.1c0,0,0,0,0,0c0,0,0,0,0,0
                            c0,0,0-0.1,0-0.1c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                            c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0-0.1-0.1c0,0,0,0,0,0l-2.4-2.3C14.2,4,14,3.9,13.8,3.9c-0.2,0-0.4,0.1-0.6,0.2
                            c-0.3,0.3-0.3,0.8,0,1.1L14.3,6.2z"/>
                        <path class="st0" d="M0.8,14h10.1c0.4,0,0.8-0.3,0.8-0.8v-3.1c0-0.4-0.4-0.8-0.8-0.8c-0.4,0-0.8,0.3-0.8,0.8v2.3H1.6V1.6h8.5v2.3
                            c0,0.4,0.4,0.8,0.8,0.8c0.4,0,0.8-0.3,0.8-0.8V0.8c0-0.4-0.4-0.8-0.8-0.8H0.8C0.4,0,0,0.3,0,0.8v12.4C0,13.7,0.4,14,0.8,14z"/>
                    </svg>
                </span>
            </a>
        </div>
        <div class="sidebar_footer hidden-h">
            <a href="/auth/logout">
                <span>{!! Helpers::translate('logout', 'Logout') !!}</span>
                <span>
                   <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 17 14" style="enable-background:new 0 0 17 14;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:#FFFFFF;}
                        </style>
                        <path class="st0" id="arrow" d="M14.3,6.2H5C4.6,6.2,4.3,6.6,4.3,7c0,0.4,0.4,0.8,0.8,0.8h9.2l-1,1c-0.3,0.3-0.3,0.8,0,1.1
                            c0.3,0.3,0.8,0.3,1.1,0l2.4-2.3c0,0,0,0,0.1-0.1c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                            c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0-0.1,0-0.1c0,0,0,0,0,0c0,0,0,0,0,0
                            c0,0,0-0.1,0-0.1c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                            c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0-0.1-0.1c0,0,0,0,0,0l-2.4-2.3C14.2,4,14,3.9,13.8,3.9c-0.2,0-0.4,0.1-0.6,0.2
                            c-0.3,0.3-0.3,0.8,0,1.1L14.3,6.2z"/>
                        <path class="st0" d="M0.8,14h10.1c0.4,0,0.8-0.3,0.8-0.8v-3.1c0-0.4-0.4-0.8-0.8-0.8c-0.4,0-0.8,0.3-0.8,0.8v2.3H1.6V1.6h8.5v2.3
                            c0,0.4,0.4,0.8,0.8,0.8c0.4,0,0.8-0.3,0.8-0.8V0.8c0-0.4-0.4-0.8-0.8-0.8H0.8C0.4,0,0,0.3,0,0.8v12.4C0,13.7,0.4,14,0.8,14z"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
    <div class="admin_main" id="jumpout-app">
        @yield('content')    
        <adddomainpopup></adddomainpopup>    
    </div>

    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
    <script src="/js/app.js" type="text/javascript"></script>
    <script src="/js/jumpout.js" type="text/javascript"></script>
    
    <!-- BEGIN JIVOSITE CODE {literal} -->
    <!--<script type='text/javascript'>
    (function(){ var widget_id = '9e5Q5okGZa';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
    </script>-->
    <!-- {/literal} END JIVOSITE CODE -->

</body>
</html>
