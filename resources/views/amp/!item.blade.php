<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $article->title }}</title>
    <meta name="description" content="{{ $article->description }}">
    <link rel="stylesheet" type="text/css" href="/css/style.min.css">
    <script src="/js/scripts.min.js" type="text/javascript"></script>
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
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-offset-3 col-lg-5 col-md-offset-1 col-md-6 col-sm-offset-4 col-sm-2 col-x-offset-1 col-x-3 col-xs-offset-1 col-xs-2">
                <div class="subscribe_blog">
                    <form class="subscribe_blog_form">
                        <input type="email" placeholder="Enter email to get our weekly newsletter">
                        <button>Subscribe</button>
                    </form>
                </div>
                <div class="blog_mobile_icon">
                    <div class="blog_menu_burger">
                        <div class="c-menu_burger">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="blog_mobile_menu">
                            <div class="c-blog_mobile_menu c-menu_mobile">
                                <div class="menu_lang">
                                    <div class="menu_lang_text">
                                        <p>Language:</p>
                                        <p class="menu_lang_active"><span class="menu_lang_active_t">ENG</span><span class="menu_lang_icon"></span></p>
                                    </div>
                                    <ul>
                                        <li><a href="">English</a></li>
                                        <li><a href="">Russian</a></li>
                                        <li><a href="">Germany</a></li>
                                        <li><a href="">Italian</a></li>
                                        <li><a href="">French</a></li>
                                    </ul>
                                </div>
                                <ul class="main_menu">
                                    @foreach($categories as $category)
                                        <li><a href="/blog/{!! $category->url !!}" class="main_menu_link">{!! $category->h1 !!}</a></li>
                                    @endforeach
                                </ul>
                                <div class="blog_mobile_menu_search">
                                    <form class="blog_mobile_menu_search_form">
                                        <div class="search_blog_form_row">
                                            <input type="text" id="search_blog" placeholder="Search">
                                        </div>
                                        <button class="search_blog_btn"></button>
                                    </form>
                                </div>
                                <div class="blog_mobile_menu_subscribe">
                                    <form class="subscribe_blog_form">
                                        <input type="email" placeholder="Enter email to get our newsletter">
                                        <button>Subscribe</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile_subscribe_blog">
                        <div class="subscribe_blog_icon"></div>
                    </div>
                    <div class="mobile_search_blog">
                        <div class="search_blog_icon"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 hidden-sm hidden-xs">
                <nav class="menu_blog">
                    <ul>
                        @foreach($categories as $category)
                            <li class="menu_blog_item"><a href="/blog/{!! $category->url !!}" class="menu_blog_link">{!! $category->h1 !!}</a></li>
                        @endforeach
                    </ul>
                </nav>
                <div class="search_blog">
                    <div class="search_blog_icon"></div>
                </div>
            </div>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="one_blog_title">
                    <div class="caption_blog">
                        <p><span class="blog_theme">{!! $article->category($article->category_id)->name !!} </span> | <span class="blog_time">{{ $article->conversion }} min read</span></p>
                        <p class="date">{!! \Carbon\Carbon::createFromTimeString($article->created_at)->toFormattedDateString() !!}</p>
                    </div>
                    <h1>{!! $article->h1 !!}  </h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="blog_img">
                    <img src="/{{ $article->image }}" alt="">
                </div>
                <div class="article_blog">
                    <div class="c-article_blog">
                       {!! $article->content !!}     
                    </div>
                    <div class="article_blog_bottom">
                        <div class="article_blog_author">
                            <div class="author_blog_avatar">
                                <img src="/img/author.png" alt="">
                            </div>
                            <div class="author_blog_text">
                                <p>Author</p>
                                <p class="author_blog_name">Greg Hickman</p>
                            </div>
                        </div>
                        <div class="article_blog_share">
                            <p>Share:</p>
                            <div class="article_blog_share_link">
<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="//yastatic.net/share2/share.js"></script>
<div class="ya-share2" data-services="facebook,twitter,linkedin,telegram"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="page_text">
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
                            <a href="/privacy" target="_blank">Privacy policy</a> / <a href="">Terms of Use</a> / <a href="/blog">Blog</a> / <a href="/affiliate">Affiliate</a> 
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
</body>
</html>
 