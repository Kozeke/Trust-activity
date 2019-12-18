@extends('Panel::layouts/app')

@section('content')
 
    <div class="admin_header">
        <div class="admin_title">
            <h1>Welcome aboard!</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8 welcome-block"> 
                    <div class="guide_step_title">
                        <h2>👍 Good job! </h2> 
                    </div>
                    <div class="guide_step_desc">
                        <h2>Registration is almost complete.</h2>
                        <p>To start using Trust Activity -  add your first Domain by clicking on button below.</p>
                        <button class="btn btn_fon" id="welcome-add"><span></span> <span>New Domain</span></button>
                        <p class="p-margin-10">Before you start - we strongly recommend to watch our video instruction. It helps get best results! 👇</p>
                    </div>
                    <div class="video_large">
                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/zybFYQNwWrY" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        <!--<img src="/img/video_poster.png" style="width: 100%; height: 100%;">
                        <div class="video_large_title">What Happens After The Sale: Onboarding + Client Campaign <br />Walkthrough</div>
                        <div class="video_play_btn"></div>-->
                    </div>
                </div>
            </div>

        </div>
    </div>

 
@endsection
