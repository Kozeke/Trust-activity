@extends('Panel::layouts/admin')

@section('content')
 
    <div class="admin_header">
        <div class="admin_title">
            <h1>FAQ categories</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/questions" class="breadcrumbs_link">FAQ categories</a></li>
           <li class="breadcrumbs_item active">{{ $category->name_en }}</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                	<div class="new_campaign_link">
                		<a href="/admin/questions/{{ $category->id }}/create-article" class="btn">
                			<span></span>
                			<span>Add article</span>
                		</a>
                	</div>
                    <div class="notification_tabs">
                        <div class="notification_tabs_content active">
                            @foreach($articles as $article)
                                <div class="notification_item">
                                    <div class="notification_name">
                                        <div class="notification_name_text"><a href="{{ '/admin/faq/'.$category->url_en.'/'.$article->url_en }}" target="_blank">{{ $article->h1_en }}</a></div>
                                        <div class="notification_name_options">
                                            <a hre="{{ URL::to('/') }}/blog/{{ $article->url_en }}"></a> 
                                        </div>
                                    </div>
                                    <div class="notification_settings">
                                        <div class="c-notification_settings">
                                            <a href="/admin/questions/{{ $category->id }}/edit/{{ $article->id }}" class="notification_settings_link contacts_link"><span class="notification_settings_icon"></span><span>Edit</span></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 

@endsection
