@extends('faq/layout')

@section('title', 'Faq')
@section('description', 'Faq')

@section('content')
    <div class="admin_header">
        <div class="container"> 
            <div class="admin_title">
                <h1>{!! Helpers::translate('frequently-asked-questions', 'Frequently Asked Questions') !!}</h1>
            </div>
        </div>
    </div>
    <div class="container">    
        <div class="admin_content">
            <div class="container admin_container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="faq_search">
                            <form>
                                <!--<button></button>
                                <input type="search" placeholder="Type to search...">-->
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                @foreach($faq_categories as $category)
                    @if(isset($category->{'iconurl_'.$lang}) && isset($category->{'url_'.$lang}) && isset($category->{'name_'.$lang}))
                        <div class="col-lg-3">
                            <div class="faq_item">
                                <div class="faq_item_icon" style="background-image: url('{{ $category->{'iconurl_'.$lang} }}');"></div>
                                <div class="faq_item_link">
                                @if(isset($category->{'externalurl_'.$lang}))
                                    <a href="{{ $category->{'externalurl_'.$lang} }}">{{ $category->{'name_'.$lang} }}</a>
                                @else
                                     <a href="/faq/{{ $category->{'url_'.$lang} }}">{{ $category->{'name_'.$lang} }}</a>
                                @endif 
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="support_box">
                            <div class="support_box_icon"></div>
                            <div class="support_box_desc">
                                <div class="support_box_title">Introducing phone and chat support</div>
                                <div class="support_box_text">Get in touch with Trust Activity Support in the way that works for you, whenever you need us. <a href="">Learn more<span></span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="other_question_block no_find_answer_block">
                            <div class="other_question_icon"></div>
                            <div class="other_question_desc">
                                <div class="other_question_title">Can’t find your answer?</div>
                                <div class="other_question_text">We’re here to help. Speak with someone <br />from Trust Activity. <a href="mailto:support@trustactivity.com">Contact us<span></span></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="other_question_block technical_questions_block">
                            <div class="other_question_icon"></div>
                            <div class="other_question_desc">
                                <div class="other_question_title">Technical questions on IRC</div>
                                <div class="other_question_text">Got any technical questions? Our developers <br />hang out in <a href="">#trustactivity</a> on freenode.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection
