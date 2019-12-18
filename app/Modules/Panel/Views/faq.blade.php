@extends('Panel::layouts/app')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Frequently Asked Questions</h1>
        </div>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="faq_search">
                        <form>
                            <button></button>
                            <input type="search" placeholder="Type to search...">
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="faq_item">
                        <div class="faq_item_icon start_icon"></div>
                        <div class="faq_item_link">
                            <a href="">How to start using</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="faq_item">
                        <div class="faq_item_icon troubleshooting_icon"></div>
                        <div class="faq_item_link">
                            <a href="">Troubleshooting</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="faq_item">
                        <div class="faq_item_icon services_icon"></div>
                        <div class="faq_item_link">
                            <a href="">Services</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="faq_item">
                        <div class="faq_item_icon setup_icon"></div>
                        <div class="faq_item_link">
                            <a href="">Setup and Adjustments</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="faq_item">
                        <div class="faq_item_icon integrations_icon"></div>
                        <div class="faq_item_link">
                            <a href="">Integrations</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="faq_item">
                        <div class="faq_item_icon account_icon"></div>
                        <div class="faq_item_link">
                            <a href="">Account and Billing</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="faq_item">
                        <div class="faq_item_icon questions_icon"></div>
                        <div class="faq_item_link">
                            <a href="">Other Questions</a>
                        </div>
                    </div>
                </div>
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
                            <div class="other_question_text">We’re here to help. Speak with someone <br />from Trust Activity. <a href="">Contact us<span></span></a></div>
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


@endsection
