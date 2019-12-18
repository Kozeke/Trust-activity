@extends('Panel::layouts/app')

@section('title', $article->{'title_'.$lang})
@section('description', $article->{'description_'.$lang})

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>{{ $article->{'h1_'.$lang} }}</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/faq" class="breadcrumbs_link">{!! Helpers::translate('faq', 'FAQ') !!}</a></li>
            <li class="breadcrumbs_item"><a href="/admin/faq/{{ $category->{'url_'.$lang} }}" class="breadcrumbs_link">{{ $category->{'h1_'.$lang} }}</a></li>       
            <li class="breadcrumbs_item active">{{ $article->{'h1_'.$lang} }}</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_title">
                        <h2>{{ $article->{'description_'.$lang} }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_desc">
                        {!! $article->{'content_'.$lang} !!}
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection
