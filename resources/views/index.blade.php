<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="canonical" href="{!! secure_url('/') !!}">
    <link rel="alternate" hreflang="en" href="{!! secure_url('/') !!}">
    <link rel="amphtml" href="{!! secure_url('/') !!}/amp">
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:locale" content="en_US"><meta property="og:type" content="website">
    <meta property="og:title" content="Trust Activity - Social Proof Software">
    <meta property="og:url" content="https://www.trustactivity.com/">
    <meta property="og:description" content="Increase Sales and Grow Your Business with Social Proof Software. TrustActivity builds trust. Trust increase sales. Let your existing customers sell for you!"><meta property="og:site_name" content="Trust Activity">
    <meta property="og:image" content="">
    <meta name="twitter:card" content="summary"><meta name="twitter:description" content="Increase Sales and Grow Your Business with Social Proof Software. TrustActivity builds trust. Trust increase sales. Let your existing customers sell for you!">
    <meta name="twitter:title" content="Trust Activity - Boost Conversion and Sales up to 200%. Social Proof Software. Recent Sales and SignUp Popups.">
    <meta name="twitter:image" content="">
    <title>Trust Activity - Social Proof Software</title>
    <meta name="description" content="Increase Sales and Grow Your Business with Social Proof Software. TrustActivity builds trust. Trust increase sales. Let your existing customers sell for you!">
    <meta name="author" content="TrustActivity"><meta name="copyright" content="© 2017 — 2019 www.trustactivity.com. TrustActivity - Boost Conversion and Sales"><meta name="contact" content="support@trustactivity.com">
    <link rel="stylesheet" type="text/css" href="/css/style.min.css">
    <script src="/js/scripts.min.js" type="text/javascript"></script>
    <!-- Global site tag (gtag.js) - Google Ads: 791463974 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-791463974"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-791463974');
    </script>
    <!-- Event snippet for Регистрация на ТА conversion page -->
    <script>
      gtag('event', 'conversion', {'send_to': 'AW-791463974/L6HoCMbyiIwBEKaQs_kC'});
    </script>

    <script src="/js/tiny-slider.js"></script>

</head>
<body>
    <header>
        <div class="line_menu header" id="header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-7 col-xs-8">
                        <div class="logo_header">
                            <div class="logo_header_img">
                                <a href="/"></a>
                            </div>
                            <div class="lang">
                                <a href="" class="lang_active">ENG</a>
                                <div class="lang_list_block">
                                    <ul class="lang_list">
                                        <li><a href="https://www.trustactivity.com/">English</a></li>
                                        <li><a href="http://www.trustactivity.ru/">Русский</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-offset-1 col-lg-6 visible-lg">
                        <div class="header_menu">
                            <nav>
                                <ul>
                                    <li><a href="#intro_block" class="header_menu_link">Intro</a></li>
                                    <li><a href="#how_block" class="header_menu_link">How it works</a></li>
                                    <li><a href="#functions_block" class="header_menu_link">Functions</a></li>
                                    <li><a href="#advantages_block" class="header_menu_link">Advantages</a></li>
                                    <li><a href="#pricing_block" class="header_menu_link">Pricing</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-offset-0 col-lg-2 col-md-offset-5 col-md-3 col-sm-offset-3 col-sm-3 col-x-offset-1 col-x-4 col-xs-offset-2 col-xs-2">
                        <div class="menu_burger">
                            <div class="c-menu_burger">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <div class="menu_mobile">
                                <div class="c-menu_mobile">
                                    <div class="menu_lang">
                                        <div class="menu_lang_text">
                                            <p>Language:</p>
                                            <p class="menu_lang_active"><span class="menu_lang_active_t">ENG</span><span class="menu_lang_icon"></span></p>
                                        </div>
                                        <ul>
                                        <li><a href="https://www.trustactivity.com/">English</a></li>
                                        <li><a href="http://www.trustactivity.ru/">Русский</a></li>
                                        </ul>
                                    </div>
                                    <ul class="main_menu">
                                        <li><a href="#intro_block" class="main_menu_link"><span class="icon_main_menu icon_intro"></span><span>Intro</span></a></li>
                                        <li><a href="#how_block" class="main_menu_link"><span class="icon_main_menu icon_how_work"></span><span>How it works</span></a></li>
                                        <li><a href="#functions_block" class="main_menu_link"><span class="icon_main_menu icon_functions"></span><span>Functions</span></a></li>
                                        <li><a href="#advantages_block" class="main_menu_link"><span class="icon_main_menu icon_advantages"></span><span>Advantages</span></a></li>
                                        <li><a href="#pricing_block" class="main_menu_link"><span class="icon_main_menu icon_pricing"></span><span>Pricing</span></a></li>
                                    </ul>
                                    <div class="personal_menu">
                                        @if(Auth::user())
                                            <a href="/admin" class="personal_menu_sing">Dashboard</a>
                                        @else
                                            <a href="/auth/login" class="personal_menu_login"><span>Login</span><span></span></a>
                                            <a href="/auth/register" class="personal_menu_sing">Sign Up</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header_profile">
                            <ul>
                                @if(Auth::user())
                                    <li><a href="/admin" class="sing_up">Dashboard</a></li>
                                @else
                                    <li><a href="/auth/login" class="login">Login</a></li>
                                    <li><a href="/auth/register" class="sing_up">Sign Up</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                    <div class="header_desc_box">
                        <div class="header_title"><h1>Increase Sales and <br />Grow Your Business <br />By Adding One Line Of Code</h1></div>
                        <div class="header_text"><p>Install Our Script on Your Website and Grow Sales Instantly! <br />100% Satisfaction  or Money Back Guarantee!</p></div>
                        <div class="header_video_link">
                            <a data-fancybox href="https://www.youtube.com/watch?v=4Jz_Blac1eg">
                                <span class="header_video_link_icon"></span>
                                <span class="header_video_link_text">How Trust Activity Works</span>
                            </a>
                        </div>
                        <div class="header_form">
                            <form>
                                <div class="header_form_icon"></div>
                                <input type="email" placeholder="Enter your email" name="" autocomplete="off">
                                <button class="btn trial-btn">Start 7-Day Free Trial</button>
                                <p class="see_reviews" style="display:none;">See our <span class="fw_m">4</span> reviews <span class="star_green"></span> on Trustpilot</p>
                                <p>Cancel Any Time</p>
                            </form>
                        </div>
                        <div class="header_link">
                            <a href="/auth/register?utm_source=site&utm_medium=newlink&utm_campaign=newlink" class="btn">Start 7-Day Free Trial</a>
                            <!--<p class="see_reviews">See our <span class="fw_m">4</span> reviews <span class="star_green"></span> on Trustpilot</p>-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12">
                    <div class="circle_block">
                        <div class="circle_heart"></div>
                        <div class="circle_smile"></div>
                        <div class="circle_fire"></div>
                        <div class="circle_geo"></div>
                        <div class="proof"></div>
                    </div>
                    <div class="phone_abs">
                        <div class="c-phone_abs active">
                            <img src="img/phone_bg_1.svg" alt="">
                        </div>
                        <div class="c-phone_abs">
                            <img src="img/phone_bg_2.svg" alt="">
                        </div>
                        <div class="c-phone_abs">
                            <img src="img/phone_bg_3.svg" alt="">
                        </div>
                        <div class="c-phone_abs">
                            <img src="img/phone_bg_4.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="how_block" id="intro_block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-lg-push-7 col-md-5 col-md-push-7 col-xs-12">
                        <div class="main_title">
                            <h2>How We Can Help Your Company Grow</h2>
                        </div>
                        <div class="main_desc">
                            <p>TrustActivity display lead or sale notifications to visitors in real-time on your website. <br /><span>We show only true info!</span> People trust our notifications and as result - they trust your website!</p>
                        </div>
                        <div class="main_link">
                            <a href="/auth/register?utm_source=site&utm_medium=newlink&utm_campaign=newlink" class="btn">Try for free</a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-lg-pull-5 col-md-7 col-md-pull-5 col-xs-12">
                        <div class="video_mac">
                            <img src="img/mac_video.png" alt="">
                            <div class="play_btn">
                                <a data-fancybox href="https://www.youtube.com/watch?v=4Jz_Blac1eg">
                                    <img src="img/video_btn.svg" alt="">
                                </a>
                            </div>
                            <!--<div class="video_img">-->
                                <!--<img src="img/video_bg.png" alt="">-->
                                <!---->
                            <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="b2b_block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7 col-sm-9 col-xs-12">
                        <div class="main_list green_list">
                            <p class="main_list_title">The Basics Of Our Business</p>
                            <ul>
                                <li><span></span><span>Give only true information</span></li>
                                <li><span></span><span>Help your visitors trust your website</span></li>
                                <li><span></span><span>Help you grow conversions and boost your sales</span></li>
                            </ul>
                        </div>
                        <div class="main_list blue_list">
                            <p class="main_list_title">Make it simple</p>
                            <ul>
                                <li><span></span><span>SEO Friendly</span></li>
                                <li><span></span><span>Quick installation</span></li>
                                <li><span></span><span>User-friendly</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5 col-sm-3 pos-abs hidden-xs">
                        <div class="notification_slider">
                            <div class="c-notification_slider" id="notification_slider">
                                <div class="notification_slider_item">
                                    <div class="notification_slider_block">
                                        <div class="notification_img">
                                            <img src="img/fire2.svg" alt="">
                                        </div>
                                        <div class="notification_desc">
                                            <div class="notification_desc_title"><span>277 visitors</span> signed up in the last 24 hours</div>
                                            <div class="notification_desc_by">
                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification_slider_item">
                                    <div class="notification_slider_block">
                                        <div class="notification_img">
                                            <img src="img/eye.svg" alt="">
                                        </div>
                                        <div class="notification_desc">
                                            <div class="notification_desc_title"><span>315 visitors</span>  currently viewing this page</div>
                                            <div class="notification_desc_by">
                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification_slider_item">
                                    <div class="notification_slider_block">
                                        <div class="notification_img">
                                            <img src="img/map.svg" alt="">
                                        </div>
                                        <div class="notification_desc">
                                            <div class="notification_desc_title">Someone from Bentleigh East...</div>
                                            <div class="notification_desc_text">Recently signed up for TrustActivity</div>
                                            <div class="notification_desc_time">2 minutes ago</div>
                                            <div class="notification_desc_by">
                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification_slider_item">
                                    <div class="notification_slider_block">
                                        <div class="notification_img">
                                            <img src="img/rebecca.svg" alt="">
                                        </div>
                                        <div class="notification_desc">
                                            <div class="notification_desc_title">Rebecca from Washington, DC</div>
                                            <div class="notification_desc_text">Recently signed up for TrustActivity</div>
                                            <div class="notification_desc_time">2 minutes ago</div>
                                            <div class="notification_desc_by">
                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div id="notification_slider">
                            <div class="c-notification_slider">
                                <div class="notification_slider_item">
                                    <div class="notification_slider_block">
                                        <div class="notification_img">
                                            <img src="img/fire2.svg" alt="">
                                        </div>
                                        <div class="notification_desc">
                                            <div class="notification_desc_title"><span>277 visitors</span> signed up in the last 24 hours</div>
                                            <div class="notification_desc_by">
                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification_slider_item">
                                    <div class="notification_slider_block">
                                        <div class="notification_img">
                                            <img src="img/eye.svg" alt="">
                                        </div>
                                        <div class="notification_desc">
                                            <div class="notification_desc_title"><span>315 visitors</span>  currently viewing this page</div>
                                            <div class="notification_desc_by">
                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification_slider_item">
                                    <div class="notification_slider_block">
                                        <div class="notification_img">
                                            <img src="img/map.svg" alt="">
                                        </div>
                                        <div class="notification_desc">
                                            <div class="notification_desc_title">Someone from Bentleigh East...</div>
                                            <div class="notification_desc_text">Recently signed up for TrustActivity</div>
                                            <div class="notification_desc_time">2 minutes ago</div>
                                            <div class="notification_desc_by">
                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification_slider_item">
                                    <div class="notification_slider_block">
                                        <div class="notification_img">
                                            <img src="img/rebecca.svg" alt="">
                                        </div>
                                        <div class="notification_desc">
                                            <div class="notification_desc_title">Rebecca from Washington, DC</div>
                                            <div class="notification_desc_text">Recently signed up for TrustActivity</div>
                                            <div class="notification_desc_time">2 minutes ago</div>
                                            <div class="notification_desc_by">
                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                    </div>
                </div>
            </div>
        </div>
        <div class="opinion_block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-offset-1 col-lg-10 col-xs-12">
                        <div class="main_review">
                            <div class="main_review_icon">
                                <img src="img/review.png" alt=""/>
                            </div>
                            <div class="main_review_title visible-xxs">
                                <p class="main_review_name">Greg Hickman</p>
                                <p class="main_review_stars">
                                    <span></span><span></span><span></span><span></span><span></span>
                                </p>
                            </div>
                            <div class="main_review_desc">
                                <div class="main_review_text">Trust Activity has developed one of the most innovative ideas in online marketing, If you're running traffic to your website, you need this pronto!</div>
                                <div class="main_review_title">
                                    <p class="main_review_name">Greg Hickman</p>
                                    <p class="main_review_stars">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="three_steps_block" id="how_block">
           <div class="one_step">
               <div class="container">
                   <div class="row">
                       <div class="col-xs-12">
                           <div class="main_title">
                               <h2>3 Steps To Make It Work</h2>
                           </div>
                           <div class="main_desc">
                               <p>Display Real-Time Customer Activity Notifications On Your Website <br />And Let Your Existing Customers Sell For You.</p>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 col-sm-offset-0 col-sm-5 col-sm-push-7 col-x-offset-1 col-x-10 col-xs-12">
                           <div class="step_desc">
                               <div class="step_title">
                                   <p><span></span>Installation</p>
                               </div>
                               <div class="step_text">
                                   <p>Install the simple marketing pixel on each page of your website. <br /> Copy and paste into the header. It will take less than 1 minute.</p>
                               </div>
                           </div>
                       </div>
                       <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 col-sm-offset-0 col-sm-7 col-sm-pull-5 col-x-offset-1 col-x-10 col-xs-12">
                           <div class="one_step_img">
                               <img src="img/step1_bg.svg" alt="">
                               <div class="two_step_block_animated">
                                   <div class="one_step_code_block">
                                       <div class="one_step_code_head">
                                           <div class="code_head_left">
                                               <div></div>
                                           </div>
                                           <div class="code_head_right">
                                               <div class="code_uninstalled">
                                                   <span class="code_uninstalled_icon"></span>
                                                   <span class="code_uninstalled_text">Uninstalled</span>
                                               </div>
                                               <div class="code_installed">
                                                   <span class="code_uninstalled_icon"></span>
                                                   <span class="code_installed_text">Installed</span>
                                               </div>
                                               <div class="code_copy">
                                                   <span class="copy_black"></span>
                                                   <span class="copy_green"></span>
                                                   <span class="code_copy_text">Copy</span>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="one_step_code_body">
                                           <code class="code_for_user" id="foo">
                                               <span class="token_tag"><span class="token_punctuation">&lt;</span>script</span>
                                               <span class="token_type">type</span>
                                               <span class="token_punctuation">=</span>
                                               <span class="token_string"><span class="token_punctuation">"</span>text/javascript<span class="token_punctuation">"</span></span>
                                               <span class="token_type">src</span>
                                               <span class="token_punctuation">=</span>
                                               <span class="token_string"><span class="token_punctuation">"</span>http://trustactivity.com/cdn/truster.js?acc=$2y$10$BXlWE4PEAjVhhCj8WHkTVO0zalXSPVyyAGrWYrkMaYoBM1OCFWIDC<span class="token_punctuation">"</span><span class="token_punctuation">&gt;</span><span class="token_tag"><span class="token_punctuation">&lt;</span><span class="token_punctuation">/</span>script<span class="token_punctuation">&gt;</span></span></span>
                                           </code>
                                       </div>
                                   </div>
                                   <div class="one_step_img_block"></div>
                                   <div class="one_step_img_block"></div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
            <div class="two_step">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-4 col-md-offset-0 col-md-5 col-sm-offset-0 col-sm-5 col-x-offset-1 col-x-10 col-xs-12">
                            <div class="step_desc">
                                <div class="step_title">
                                    <p><span></span>Connect and Adjust</p>
                                </div>
                                <div class="step_text">
                                    <p>Create a new campaign in the dashboard <br />  then follow the steps to get the best results. <br />  No technical experience required.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-offset-0 col-lg-6 col-md-offset-1 col-md-6 col-sm-offset-0 col-sm-7 col-x-offset-1 col-x-10 col-xs-12">
                            <div class="two_step_img">
                                <img src="img/step1_bg.svg" alt="">
                                <div class="two_step_block_animated">
                                    <div class="nav_step_block_animated">
                                        <ul>
                                            <li class="nav_step_block_item active nav_step_block_item1">
                                                <span>Beginning</span>
                                                <span></span>
                                            </li>
                                            <li class="nav_step_block_item nav_step_block_item2">
                                                <span>Capture</span>
                                                <span></span>
                                            </li>
                                            <li class="nav_step_block_item nav_step_block_item3">
                                                <span>Display</span>
                                                <span></span>
                                            </li>
                                            <li class="nav_step_block_item nav_step_block_item4">
                                                <span>Customize</span>
                                                <span></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="desc_step_block_animated">
                                        <div class="c-desc_step_block">
                                            <div class="desc_step_block_item desc_step_block_item1">
                                                <div class="desc_step_block_circle"></div>
                                                <div class="desc_step_block_line"></div>
                                                <div class="desc_step_block_trigger"></div>
                                            </div>
                                            <div class="desc_step_block_item desc_step_block_item2">
                                                <div class="desc_step_block_circle"></div>
                                                <div class="desc_step_block_line"></div>
                                                <div class="desc_step_block_trigger"></div>
                                            </div>
                                            <div class="desc_step_block_item desc_step_block_item3">
                                                <div class="desc_step_block_circle"></div>
                                                <div class="desc_step_block_line"></div>
                                                <div class="desc_step_block_trigger"></div>
                                            </div>
                                            <div class="desc_step_block_item desc_step_block_item4">
                                                <div class="desc_step_block_circle"></div>
                                                <div class="desc_step_block_line"></div>
                                                <div class="desc_step_block_trigger"></div>
                                            </div>
                                        </div>
                                        <div class="link_step_block_animated">
                                            <div class="link_step_block_left">
                                                <div></div>
                                            </div>
                                            <div class="link_step_block_right">
                                                <div class="next_btn_step_block"></div>
                                                <div class="finish_btn_step_block"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="three_step">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 col-sm-offset-0 col-sm-5 col-sm-push-7 col-x-offset-1 col-x-10 col-xs-12">
                            <div class="step_desc">
                                <div class="step_title">
                                    <p><span></span>See The Magic!</p>
                                </div>
                                <div class="step_text">
                                    <p>Get ready for take-off! Your visitors will start increasing within days. <br /> Kickback and watch your conversions go viral.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 col-sm-offset-0 col-sm-7 col-sm-pull-5 col-x-offset-1 col-x-10 col-xs-12">
                            <div class="three_step_img">
                                <img src="img/step2_bg.svg" alt="">
                                <div class="three_step_block_animated">
                                    <div class="three_step_notification three_step_notification1"></div>
                                    <div class="three_step_notification three_step_notification2"></div>
                                    <div class="three_step_notification three_step_notification3"></div>
                                    <div class="three_step_notification three_step_notification4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="functions_block" id="functions_block">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="main_title">
                            <h2>Social proof tool functions</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 hidden-xs">
                        <div class="tabs_block">
                            <ul class="tabs_list">
                                <li class="active">Notification</li>
                            </ul>
                            <div class="tabs_content active">
                                <div class="tabs_content_1">
                                    <div class="tabs_content_left">
                                        <div class="tabs_text">
                                            <p>If you are involved with Internet Marketing, then you know the market place is getting more and more competitive. And there are many moving parts to deal with at the same time.</p>
                                            <p>One of these moving parts is conversion rate optimization. In other words how to convert your website visitors to customers, this is the Holy Grail of IM.</p>
                                            <p>And this is what our product Notifications will help you achieve.</p>
                                            <p>Social proof notifications build trust. Trust + a great offer = sales. More sales = more social proof. Let your existing customers sell for you!</p>
                                        </div>
                                        <div class="tabs_button">
                                            <a href="/auth/register" class="btn">Try for free</a>
                                        </div>
                                    </div>
                                    <div class="tabs_content_right">
                                        <div class="monitor_abs">
                                            <div class="c-monitor_abs">
                                                <div class="notification_block">
                                                    <div class="notification_item notification_item1 active">
                                                        <div class="notification_img"></div>
                                                        <div class="notification_desc">
                                                            <div class="notification_desc_title"><span>277 visitors</span> signed up in the last 24 hours</div>
                                                            <div class="notification_desc_by">
                                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="notification_item notification_item2">
                                                        <div class="notification_img"></div>
                                                        <div class="notification_desc">
                                                            <div class="notification_desc_title"><span>315 visitors</span> currently viewing this page</div>
                                                            <div class="notification_desc_by">
                                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="notification_item notification_item3">
                                                        <div class="notification_img"></div>
                                                        <div class="notification_desc">
                                                            <div class="notification_desc_title">Someone from Bentleigh East...</div>
                                                            <div class="notification_desc_text">Recently signed up for TrustActivity</div>
                                                            <div class="notification_desc_time">2 minutes ago</div>
                                                            <div class="notification_desc_by">
                                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="notification_item notification_item4">
                                                        <div class="notification_img"></div>
                                                        <div class="notification_desc">
                                                            <div class="notification_desc_title">Rebecca from Washington, DC</div>
                                                            <div class="notification_desc_text">Recently signed up for TrustActivity</div>
                                                            <div class="notification_desc_time">2 minutes ago</div>
                                                            <div class="notification_desc_by">
                                                                <span class="done"></span> by <span class="green_text">Trust Activity</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 visible-xs">
                        <div class="panel-group" id="accordion">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="show">Notification <span class="panel_arrow"></span></a>
                                    </div>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="tabs_text">
                                          <p>If you are involved with Internet Marketing, then you know the market place is getting more and more competitive. And there are many moving parts to deal with at the same time.</p>
                                          <p>One of these moving parts is conversion rate optimization. In other words how to convert your website visitors to customers, this is the Holy Grail of IM.</p>
                                          <p>And this is what our product Notifications will help you achieve.</p>
                                          <p>Social proof notifications builds trust. Trust + a great offer = sales. More sales = more social proof. Let your existing customers sell for you!</p>
                                        </div>
                                        <div class="tabs_button">
                                            <a href="" class="btn">Try for free</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="advantages_block" id="advantages_block">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="main_title">
                            <h2>Our Advantages</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-6 col-xs-12">
                        <div class="advantages_item">
                            <div class="advantages_icon advantages_icon1"></div>
                            <div class="advantages_name">Free 7-Day Trial</div>
                            <div class="advantages_text">We sure that you will be happy to work with us! Try our service to check it out! </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-6 col-xs-12">
                        <div class="advantages_item">
                            <div class="advantages_icon advantages_icon2"></div>
                            <div class="advantages_name">Custom Notifications</div>
                            <div class="advantages_text">Display recent sales and opt-ins on your pages and drive visitors to convert.</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-6 col-xs-12">
                        <div class="advantages_item">
                            <div class="advantages_icon advantages_icon3"></div>
                            <div class="advantages_name">Mobile Friendly</div>
                            <div class="advantages_text">Trustactivity notifications look great on any device. Whether your customer is on mobile or desktop.</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-6 col-xs-12">
                        <div class="advantages_item">
                            <div class="advantages_icon advantages_icon4"></div>
                            <div class="advantages_name">Language Translation</div>
                            <div class="advantages_text">Translate TA notifications into any language you want. It is easy.</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-6 col-xs-12">
                        <div class="advantages_item">
                            <div class="advantages_icon advantages_icon5"></div>
                            <div class="advantages_name">Custom Rules and Timing</div>
                            <div class="advantages_text">Control your notifications time rules, delay and where to display.</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-6 col-xs-12">
                        <div class="advantages_item">
                            <div class="advantages_icon advantages_icon6"></div>
                            <div class="advantages_name">Live Visitor Count</div>
                            <div class="advantages_text">Show everybody how many visitors are browsing your website. That's work amazing to boost your conversions!</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-6 col-xs-12">
                        <div class="advantages_item">
                            <div class="advantages_icon advantages_icon7"></div>
                            <div class="advantages_name">Widget Design</div>
                            <div class="advantages_text">Choose from a library of different sleek popup templates.</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-x-6 col-xs-12">
                        <div class="advantages_item">
                            <div class="advantages_icon advantages_icon8"></div>
                            <div class="advantages_name">24/7 Support</div>
                            <div class="advantages_text">We guarantee instant technical support. You can contact us directly from the service for free!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="types_site_block">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="main_title">
                            <h2>TrustActivity Works Great Everywhere!</h2>
                        </div>
                        <div class="main_desc">Our Service Is Suitable For All Types Of Websites. Only One Line Of Code <br />Separates You From Boosting Your Conversions!</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cost_block" id="pricing_block">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="main_title">
                            <h2>How Much It Costs</h2>
                        </div>
                        <div class="cost_tabs_list">
                            <ul>
                                <li class="active">Monthly billing</li>
                                <li>Annual billing</li>
                            </ul>
                        </div>
                        <div class="cost_sing">
                            <p class="active">Get 2 month for free! <img class="finger-up" src="/img/hand_shows_up.svg"></p>
                            <p>Get 2 month for free! <img class="finger-up" src="/img/hand_shows_up.svg"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="cost_tabs_content active">
                        <div class="col-lg-offset-0 col-lg-3 col-lg-3 col-md-offset-1 col-md-5 col-sm-6 col-x-6">
                            <div class="cost_item">
                                <div class="cost_name">
                                    <div class="cost_title">
                                        <p>Micro</p>
                                        <p>monthly plan</p>
                                    </div>
                                    <div class="cost_title_sing">Cancel Any Time</div>
                                </div>
                                <div class="cost_desc">
                                    <div class="main_list green_list">
                                        <ul>
                                            <li><span></span><span>Up to 10,000 Unique Visitors/mo</span></li>
                                            <li><span></span><span>All settings and 24/7 support</span></li>
                                            <li><span></span><span>Unlimited Notifications</span></li>
                                            <li><span></span><span>1 Domain</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cost_price">
                                    <div class="cost_price_text">
                                        <p class="visible_xxs">start form</p>
                                        <span>$9.99</span>
                                        <span>Per month</span>
                                    </div>
                                    <div class="cost_price_link">
                                        <a href="/auth/register" class="btn green_btn">Start free trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-lg-3 col-md-5 col-sm-6 col-x-6 hidden-xxs">
                            <div class="cost_item popular">
                                <div class="cost_name">
                                    <div class="cost_title">
                                        <p>SMALL</p>
                                        <p>monthly plan</p>
                                    </div>
                                    <div class="cost_title_sing">Cancel Any Time</div>
                                    <div class="popular_block">
                                        <p>Most <br />Popular!</p>
                                    </div>
                                </div>
                                <div class="cost_desc">
                                    <div class="main_list blue_list">
                                        <ul>
                                            <li><span></span><span>Up to 50,000 Unique Visitors/mo</span></li>
                                            <li><span></span><span>All settings and 24/7 support</span></li>
                                            <li><span></span><span>Unlimited Notifications</span></li>
                                            <li><span></span><span>1 Domain</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cost_price">
                                    <div class="cost_price_text">
                                        <span>$19</span>
                                        <span>Per month</span>
                                    </div>
                                    <div class="cost_price_link">
                                        <a href="/auth/register" class="btn blue_btn">Start free trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-offset-0 col-lg-3 col-lg-3 col-md-offset-1 col-md-5 col-sm-6 col-x-6 hidden-xxs">
                            <div class="cost_item">
                                <div class="cost_name">
                                    <div class="cost_title">
                                        <p>Medium</p>
                                        <p>monthly plan</p>
                                    </div>
                                    <div class="cost_title_sing">Cancel Any Time</div>
                                </div>
                                <div class="cost_desc">
                                    <div class="main_list green_list">
                                        <ul>
                                            <li><span></span><span>Up to 500,000 Unique Visitors/mo</span></li>
                                            <li><span></span><span>All settings and 24/7 support</span></li>
                                            <li><span></span><span>Unlimited Notifications</span></li>
                                            <li><span></span><span>1 Domain</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cost_price">
                                    <div class="cost_price_text">
                                        <span>$79</span>
                                        <span>Per month</span>
                                    </div>
                                    <div class="cost_price_link">
                                        <a href="/auth/register" class="btn green_btn">Start free trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-lg-3 col-md-5 col-sm-6 col-x-6 hidden-xxs">
                            <div class="cost_item">
                                <div class="cost_name">
                                    <div class="cost_title">
                                        <p>VIP</p>
                                        <p>monthly plan</p>
                                    </div>
                                    <div class="cost_title_sing">Cancel Any Time</div>
                                </div>
                                <div class="cost_desc">
                                    <div class="main_list green_list">
                                        <ul>
                                            <li><span></span><span>Up to 5 millions Unique vis/mo</span></li>
                                            <li><span></span><span>VIP Service</span></li>
                                            <li><span></span><span>Unlimited Notifications</span></li>
                                            <li><span></span><span>1 Domain</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cost_price">
                                    <div class="cost_price_text">
                                        <span>$199</span>
                                        <span>Per month</span>
                                    </div>
                                    <div class="cost_price_link">
                                        <a href="/auth/register" class="btn green_btn">Start free trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cost_tabs_content hidden-xxs">
                        <div class="col-lg-offset-0 col-lg-3 col-md-offset-1 col-md-5 col-sm-6 col-x-6">
                            <div class="cost_item">
                                <div class="cost_name">
                                    <div class="cost_title">
                                        <p>Micro</p>
                                        <p>yearly plan</p>
                                    </div>
                                    <div class="cost_title_sing">Cancel Any Time</div>
                                </div>
                                <div class="cost_desc">
                                    <div class="main_list green_list">
                                        <ul>
                                            <li><span></span><span>Up to 120,000 Unique Visitors/year</span></li>
                                            <li><span></span><span>All settings and 24/7 support</span></li>
                                            <li><span></span><span>Unlimited Notifications</span></li>
                                            <li><span></span><span>1 Domain</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cost_price">
                                    <div class="cost_price_text">
                                        <span>$99.9</span>
                                        <span>Per year</span>
                                    </div>
                                    <div class="cost_price_link">
                                        <a href="/auth/register" class="btn green_btn">Start free trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-lg-3 col-md-5 col-sm-6 col-x-6">
                            <div class="cost_item popular">
                                <div class="cost_name">
                                    <div class="cost_title">
                                        <p>SMALL</p>
                                        <p>yearly plan</p>
                                    </div>
                                    <div class="cost_title_sing">Cancel Any Time</div>
                                    <div class="popular_block">
                                        <p>Most <br />Popular!</p>
                                    </div>
                                </div>
                                <div class="cost_desc">
                                    <div class="main_list blue_list">
                                        <ul>
                                            <li><span></span><span>Up to 600,000 Unique Visitors/year</span></li>
                                            <li><span></span><span>All settings and 24/7 support</span></li>
                                            <li><span></span><span>Unlimited Notifications</span></li>
                                            <li><span></span><span>1 Domain</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cost_price">
                                    <div class="cost_price_text">
                                        <span>$190</span>
                                        <span>Per year</span>
                                    </div>
                                    <div class="cost_price_link">
                                        <a href="/auth/register" class="btn blue_btn">Start free trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-offset-0 col-lg-3 col-lg-3 col-md-offset-1 col-md-5 col-sm-6 col-x-6">
                            <div class="cost_item">
                                <div class="cost_name">
                                    <div class="cost_title">
                                        <p>Medium</p>
                                        <p>yearly plan</p>
                                    </div>
                                    <div class="cost_title_sing">Cancel Any Time</div>
                                </div>
                                <div class="cost_desc">
                                    <div class="main_list green_list">
                                        <ul>
                                            <li><span></span><span>Up to 6 millions Unique Visitors/year</span></li>
                                            <li><span></span><span>All settings and 24/7 support</span></li>
                                            <li><span></span><span>Unlimited Notifications</span></li>
                                            <li><span></span><span>1 Domain</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cost_price">
                                    <div class="cost_price_text">
                                        <span>$790</span>
                                        <span>Per year</span>
                                    </div>
                                    <div class="cost_price_link">
                                        <a href="/auth/register" class="btn green_btn">Start free trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-lg-3 col-md-5 col-sm-6 col-x-6">
                            <div class="cost_item">
                                <div class="cost_name">
                                    <div class="cost_title">
                                        <p>VIP</p>
                                        <p>yearly plan</p>
                                    </div>
                                    <div class="cost_title_sing">Cancel Any Time</div>
                                </div>
                                <div class="cost_desc">
                                    <div class="main_list green_list">
                                        <ul>
                                            <li><span></span><span>Up to 60 millions Unique Visitors/year</span></li>
                                            <li><span></span><span>VIP Service</span></li>
                                            <li><span></span><span>Unlimited Notifications</span></li>
                                            <li><span></span><span>1 Domain</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cost_price">
                                    <div class="cost_price_text">
                                        <span>$1 990</span>
                                        <span>Per year</span>
                                    </div>
                                    <div class="cost_price_link">
                                        <a href="/auth/register" class="btn green_btn">Start free trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reviews_block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-offset-0 col-sm-6 col-x-offset-1 col-x-10 col-xs-12">
                        <div class="reviews_item pd_r">
                            <div class="reviews_item_logo">
                                <img src="img/Sihalo.svg" alt="">
                            </div>
                            <div class="reviews_item_desc">I brought my clients over to TrustActivity and ALL of THEM has resulted in insanely scary conversion boosts. Crazy how a simple app and few minutes can sky-rocket your sales and revenue! All aboard!</div>
                            <div class="reviews_item_title">
                                <p class="reviews_item_name">Migele Grokhmann, Sihalo GmbH</p>
                                <p class="reviews_item_star">
                                    <span></span><span></span><span></span><span></span><span></span>
                                </p>
                            </div>
                            <div class="reviews_item_sing">Payments Product Manager</div>
                        </div>
                    </div>
                    <div class="col-lg-2 visible-lg">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-offset-0 col-sm-6 col-x-offset-1 col-x-10 col-xs-12">
                        <div class="reviews_item pd_l">
                            <div class="reviews_item_logo">
                                <img src="img/mercury.svg" alt="">
                            </div>
                            <div class="reviews_item_desc">We're in the e-market niche and adding a TrustActivity Social Proof widget helps us double our conversions! That's awesome boost!</div>
                            <div class="reviews_item_title">
                                <p class="reviews_item_name">Andrew Makgregor, Mercury Travel LLC</p>
                                <p class="reviews_item_star">
                                    <span></span><span></span><span></span><span></span><span></span>
                                </p>
                            </div>
                            <div class="reviews_item_sing">Payments Product Manager</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="free_trial_block">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="free_trial_title">
                            <h3>Start Your FREE Trial!</h3>
                        </div>
                        <div class="free_trial_desc">No credit card needed to start. <br />Just sign up and test our service for 7 days absolutely FREE!</div>
                        <div class="free_trial_form header_form">
                            <form>
                                <div class="free_trial_icon"></div>
                                <input type="email" placeholder="Enter your email">
                                <button class="btn trial-btn">Start 7-Day Free Trial</button>
                                <p class="free_trial_sing">Cancel Any Time</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-6 col-x-5 col-xs-12">
                    <div class="copy_block">
                        <p>&copy; TrustActivity. All Right Reserved</p>
                        <p class="social_icon">
                            <a href="https://www.facebook.com/trustactivity/" target="_blank" class="facebook"></a>
                            <a href="http://instagram.com/trustactivity/" target="_blank" class="insta"></a>
                            <a href="https://twitter.com/activity_trust" target="_blank" class="twit"></a>
                            <a href="https://t.me/TrustActivity" target="_blank" class="telegram"></a>
                            <a href="https://www.linkedin.com/company/trustactivity/" target="_blank" class="linkedin"></a>
                            <a href="https://www.youtube.com/channel/UCeyCaL5AHQeV4pXsUFWp9nA/featured?view_as=public" target="_blank" class="youtube"></a>
                        </p>
                        <p>
                            <a href="/privacy" target="_blank">Privacy policy</a> / <a href="#">Terms of Use</a> / <a href="/blog">Blog</a> / <a href="/affiliate">Affiliate</a> / <a href="/faq">Faq</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-offset-2 col-lg-5 col-md-offset-2 col-md-4 col-sm-offset-1 col-sm-5 col-x-offset-1 col-x-6 col-xs-12">
                    <div class="pay_block">
                        <div class="pay_block_item">
                            <p class="pay_block_paypal"></p>
                            <p class="pay_block_mc"></p>
                            <p class="visa"></p>
                            <p class="secure"></p>
                        </div>
                        <div class="with_love">
                            <p>Made with<span></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter49910728 = new Ya.Metrika2({ id:49910728, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/49910728" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123657225-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-123657225-1');
    </script>
    <script type="text/javascript" src="https://www.trustactivity.com/cdn/truster.js?acc=$2y$10$mYb71uh6RPndGGJwqVQi/.LeFGr/Usua2ENMUcDZ8W/EfavxatbZu"></script>
  <!--<script type="text/javascript" src="https://dev.positron-it.ru/cdn/truster.js?acc=$2y$10$Gem1dY8VBrjUKeBTZOf5zOhO9dbAZXJStIkUaZM5CzwU/UuhuS/y."></script> -->
</body>
</html>
