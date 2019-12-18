@extends('Panel::layouts/app')

@section('title', 'Video Instructions')
@section('description', 'Video Instructions')

@section('content')
 
    <div class="admin_header">
        <div class="admin_title">
            <h1>{!! Helpers::translate('video-instructions', 'Video Instructions') !!}</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item active">{!! Helpers::translate('video-instructions', 'Video Instructions') !!}</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8">
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
