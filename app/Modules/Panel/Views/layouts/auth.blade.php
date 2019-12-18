<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/css/panel.css">
    <script src="/js/panel.js" type="text/javascript"></script>
</head>
<body>
<div class="fullscreen_block">
    <main>
        <div class="header">
            <div class="header_sign_logo">
                <a href="/"></a>
            </div>
            <div class="header_sign_link">
                <a href="/auth/login"><?=(isset($translate['sign-in']) ? $translate['sign-in'] : 'Sign in');?></a>
            </div>
        </div>
        @yield('content')  
    </main>
</div>
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
    <!-- BEGIN JIVOSITE CODE {literal} -->
    <!--<script type='text/javascript'>
    (function(){ var widget_id = '9e5Q5okGZa';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
    </script>-->
    <!-- {/literal} END JIVOSITE CODE -->
</body>
</html>


 
