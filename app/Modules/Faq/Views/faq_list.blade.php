@extends('Panel::layouts/app')

@section('title', $category->{'title_'.$lang})
@section('description', $category->{'description_'.$lang})

@section('content')
 
    <div class="admin_header">
        <div class="admin_title">
            <h1>{{ $category->{'h1_'.$lang} }}</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/faq" class="breadcrumbs_link">{!! Helpers::translate('faq', 'FAQ') !!}</a></li>
            <li class="breadcrumbs_item active">{{ $category->{'h1_'.$lang} }}</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8">
                    <div class="faq_search one_faq_search">
                        <form>
                            <button></button>
                            <input type="search" placeholder="Type to search...">
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8">
                    @foreach($faq_elements as $element)
                        <div class="guide_link faq_link_item">
                            @if($element->{'externalurl_'.$lang} != NULL)
                                <a href="{{ $element->{'externalurl_'.$lang} }}">
                            @else
                                <a href="/admin/faq/{{ $category->{'url_'.$lang} }}/{{ $element->{'url_'.$lang} }}">
                            @endif
                                <div class="guide_link_title faq_link_item_title">{{ $element->{'title_'.$lang} }}</div>
                                <div class="guide_link_text faq_link_item_text">{{ $element->{'description_'.$lang} }}</div>
                                <div class="guide_link_arrow faq_link_item_arrow">
                                    <svg width="9" height="18" viewBox="0 0 9 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.21955 9.89109L1.78807 17.6306C1.37895 18.1231 0.715637 18.1231 0.306716 17.6306C-0.102239 17.1384 -0.102239 16.3402 0.306716 15.8481L5.99758 8.99987L0.306881 2.15186C-0.102073 1.65952 -0.102073 0.861394 0.306881 0.369254C0.715835 -0.123085 1.37912 -0.123085 1.78824 0.369254L8.21972 8.10885C8.42419 8.35504 8.52632 8.67735 8.52632 8.99983C8.52632 9.32247 8.42399 9.64502 8.21955 9.89109Z" transform="translate(0 18) scale(1 -1)"></path>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection
