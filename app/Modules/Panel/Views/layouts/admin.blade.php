<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="/css/panel.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <script src="/js/panel.js" type="text/javascript"></script>
    <script src="/js/vendor/tinymce/js/tinymce/jquery.tinymce.min.js" type="text/javascript"></script> 
    <script src="/js/vendor/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
</head>
    <body>
        <div class="sidebar scrollbar-macosx">
            <div class="sidebar_logo">
                <a href="/"></a>
            </div>
            <div class="sidebar_user">
                <div class="sidebar_user_icon"></div>
                <div class="sidebar_user_email">{{ Auth::user()->email }}</div>
                <div class="sidebar_user_settings">
                    <p class="sidebar_user_balance"><span>balance:</span> <span>$0</span></p>
                    <a href="" class="user_balance_up"><span>Top Up</span><span></span></a>
                </div>
            </div>
            <div class="sidebar_content">
                <div class="sidebar_item">
                    <div class="sidebar_title">Welcome</div>
                    <ul>
                        <li><a href="/admin/users" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Users</span></a></li>
                        <li><a href="/admin/blog" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Blog</span></a></li>
                        <li><a href="/admin/questions" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Faq</span></a></li>
                        <li><a href="/admin/mail-settings" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Mail sending</span></a></li>    
                        <li><a href="/admin/withdraw" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Affilate withdraw</span></a></li>         
                        <li><a href="/admin/promo-codes" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Promo codes</span></a></li>   
                        <li><a href="/admin/settings" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Settings</span></a></li>
                        <li><a href="/admin/partners-list" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Partners request</span></a></li>
                        <li><a href="/admin/languages" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Languages</span></a></li>
                        <li><a href="/admin/payment-history" class="sidebar_link"><span class="sidebar_icon sidebar_guide"></span><span>Payment history</span></a></li>
                    </ul>
                </div>
 
            </div>
            <div class="sidebar_footer">
                <a href="/auth/logout">
                    <span>Logout</span>
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
        <div class="admin_main" id="payment_history">
            @yield('content')    
        </div>
        <script src="/js/app.js" type="text/javascript"></script>
    </body>
</html>