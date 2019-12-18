<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trust Activity Blog</title>
    <meta name="description" content="Trust Activity Blog is for business with a focus on bringing you the latest marketing tips, strategies and best practices.">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="canonical" href="{{ URL::current() }}">
    <base href="{!! url('/') !!}">
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
                        <!--<li><a href="#">Deutsch</a></li>
                        <li><a href="#">Italiano</a></li>
                        <li><a href="#">Français</a></li>-->
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
                                    <!--<li><a href="" class="main_menu_link">Customer Support</a></li>
                                    <li><a href="" class="main_menu_link">Conversion</a></li>
                                    <li><a href="" class="main_menu_link">Marketing</a></li>
                                    <li><a href="" class="main_menu_link">Growth</a></li>
                                    <li><a href="" class="main_menu_link">Business</a></li>
                                    <li><a href="" class="main_menu_link">Product</a></li>
                                    <li><a href="" class="main_menu_link">Updates</a></li>-->
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
                        <!--<li class="menu_blog_item"><a href="" class="menu_blog_link">Customer Support</a></li>
                        <li class="menu_blog_item"><a href="" class="menu_blog_link">Conversion</a></li>
                        <li class="menu_blog_item"><a href="" class="menu_blog_link">Marketing</a></li>
                        <li class="menu_blog_item"><a href="" class="menu_blog_link">Growth</a></li>
                        <li class="menu_blog_item"><a href="" class="menu_blog_link">Business</a></li>
                        <li class="menu_blog_item"><a href="" class="menu_blog_link">Product</a></li>
                        <li class="menu_blog_item"><a href="" class="menu_blog_link">Updates</a></li>-->
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
            <div class="col-xs-12 hidden-xs">
                <div class="main_blog_box">
                    <div class="blog_img">
                        <img src="/{{ $articles[0]->image }}" alt="{{ $articles[0]->h1 }}">
                    </div>
                    <div class="c-main_blog_box">
                        <div class="caption_blog">
                            <p><span class="blog_theme">{{ $articles[0]->category($articles[0]->category_id)->name }}</span> | <span class="blog_time">{{ $articles[0]->conversion }} min read</span></p>
                        </div>
                        <h1 class="title_blog"><a href="/blog/{{ $articles[0]->category($articles[0]->category_id)->url }}/{{ $articles[0]->url }}">{{ $articles[0]->h1 }}</a></h1>
                        <div class="desc_blog">{{ $articles[0]->description }}</div>
                        <div class="author_blog">
                            <div class="author_blog_avatar">
                                <img src="/img/author.png" alt="">
                            </div>
                            <div class="author_blog_text">
                                <p>Author</p>
                                <p class="author_blog_name">Greg Hickman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="blog_list">
                    <div class="blog_list_item main_blog_list_item">
                        <div class="blog_item_img">
                            <img src="/{{ $articles[0]->image }}" alt="{{ $articles[0]->h1 }}">
                        </div>
                        <div class="c-blog_item">
                            <div class="caption_blog caption_blog_item">
                                <p><span class="blog_theme">{{ $articles[0]->category($articles[0]->category_id)->name }}</span> | <span class="blog_time">{{ $articles[0]->conversion }} min read</span></p>
                            </div>
                            <h2 class="title_blog title_blog_item"><a href="/blog/{{ $articles[0]->category($articles[0]->category_id)->url }}/{{ $articles[0]->url }}">{{ $articles[0]->h1 }}</a></h2>
                            <div class="desc_blog desc_blog_item">{{ $articles[0]->description }}</div>
                        </div>
                        <div class="author_blog author_blog_item">
                            <div class="author_blog_avatar">
                                <img src="/img/author.png" alt="">
                            </div>
                            <div class="author_blog_text">
                                <p>Author</p>
                                <p class="author_blog_name">Greg Hickman</p>
                            </div>
                        </div>
                    </div>
                    @for($i = 1; $i < count($articles); $i++)
                    	@if(($i - 1) % 3 == 0)
							<div class="blog_list_item" style="margin-left: 0px; margin-right: 0px;">
						@else 
							<div class="blog_list_item" style="margin-left: 68px; margin-right: 0px;">
                    	@endif
	                        <div class="blog_item_img">
	                            <img src="/{{ $articles[$i]->image }}" alt="{{ $articles[$i]->h1 }}">
	                        </div>
	                        <div class="c-blog_item">
	                            <div class="caption_blog caption_blog_item">category
	                                <p><span class="blog_theme">{{ $articles[$i]->category($articles[$i]->category_id)->name }}</span> | <span class="blog_time">{{ $articles[$i]->conversion }} min read</span></p>
	                            </div>
	                            <h2 class="title_blog title_blog_item"><a href="/blog/{{ $articles[$i]->category($articles[$i]->category_id)->url }}/{{ $articles[$i]->url }}">{{ $articles[$i]->h1 }}</a></h2>
	                            <div class="desc_blog desc_blog_item">{{ $articles[$i]->description }}</div>
	                        </div>
	                        <div class="author_blog author_blog_item">
	                            <div class="author_blog_avatar">
	                                <img src="/img/author.png" alt="">
	                            </div>
	                            <div class="author_blog_text">
	                                <p>Author</p>
	                                <p class="author_blog_name">Greg Hickman</p>
	                            </div>
	                        </div>
	                    </div>
                    @endfor
                </div>
                @if($pagination)
                <div class="pagination">
                    <ul>
                        @if($pagination['current'] > 1)
                            <? $prev = $pagination['current'] - 1; ?>
                            <li class="pagination_item"><a href="?page={!! $prev !!}" class="pagination_link_arrow pagination_arrow_prev"></a>
                        @endif
                        @for($i = 1; $i < $pagination['total'] +1; $i++)
                            @if($pagination['current'] == $i)
                                <li class="pagination_item"><a href="?page={!! $i !!}" class="pagination_link active">{!! $i !!}</a></li>
                            @else
                                <li class="pagination_item"><a href="?page={!! $i !!}" class="pagination_link">{!! $i !!}</a></li>
                            @endif
                        @endfor
                        @if($pagination['current'] < $pagination['total'])
                            <? $next = $pagination['current'] + 1; ?>
                            <li class="pagination_item"><a href="?page={!! $next !!}" class="pagination_link_arrow pagination_arrow_next"></a></li>
                        @endif
                    </ul>
                </div>
                @endif
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
 