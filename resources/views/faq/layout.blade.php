<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="canonical" href="{!! secure_url('/') !!}">
    <link rel="alternate" hreflang="en" href="{!! secure_url('/') !!}">
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/panel.css">
    <link rel="stylesheet" type="text/css" href="/css/faq.min.css">

    <meta property="og:locale" content="en_US"><meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:url" content="{!! secure_url('/') !!}">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:site_name" content="Trust Activity">
    <meta name="description" content="@yield('description')">
    <meta name="author" content="TrustActivity"><meta name="copyright" content="© 2017 — 2019 www.trustactivity.com. TrustActivity - Boost Conversion and Sales"><meta name="contact" content="support@trustactivity.com">
</head>
    <body>
        <header class="header_blog">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-5 col-sm-6 col-x-8 col-xs-9">
                        <div class="logo_blog">
                            <a href="/" class="logo_blog_img"></a>
                        </div>
                        <div class="lang">
                            <a href="" class="lang_active">ENG</a>
                            <div class="lang_list_block">
                                <ul class="lang_list">
                                    <li><a href="https://www.trustactivity.com/">English</a></li>
                                    <li><a href="http://www.trustactivity.ru/">Русский</a></li>
                                <!--<li><a href="#">Deutsch</a></li>
                                <li><a href="#">Italiano</a></li>
                                <li><a href="#">Français</a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="admin_main" style="padding-left: 0;">
            @yield('content')   
        </div>
    </body>
</html>