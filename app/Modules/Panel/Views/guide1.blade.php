@extends('Panel::layouts/app')

@section('title', 'Guide: step 1')
@section('description', 'Guide: step 1')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Step 1: Add Domain and Install the Pixel</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/guide" class="breadcrumbs_link">Guide</a></li>
            <li class="breadcrumbs_item active">Step 1: Add Domain and Install the Pixel</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_title">
                        <h2>Learn how to add domain in the system <br />and install TrustActivity pixel on it.</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_item">
                        <div class="guide_step_number">
                            <div class="guide_step_number_text">
                                <span>1</span>
                                <span>Step</span>
                            </div>
                        </div>
                        <div class="guide_step_desc">
                            <p>The first step before you start getting social proof notifications is adding domain in the dashboard. It is very easy and fast – by clicking button “+ New Domain” and filling 2 fields: <br /><span class="bold_text">Domain Name</span> (as you will see it in the dashboard) and <span class="bold_text">Domain URL</span>.</p>
                        </div>
                        <div class="guide_step_img">
                            <img src="/img/guide1.gif" width="900" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-lg-offset-1 col-lg-10">
                <div class="guide_step_item">
                    <div class="guide_step_number">
                        <div class="guide_step_number_text">
                            <span>2</span>
                            <span>Step</span>
                        </div>
                    </div>
                    <div class="guide_step_desc">
                        <p>After that TrustActivity will generate individual script which you should setup on all website pages to the header section. The pixel is used to capture your website activity and display notifications in future.</p>
                    </div>
                    <div class="guide_step_img">
                        <img src="/img/guide2.png" alt="">
                    </div>
                    <div class="guide_step_note">
                        <p>NOTE: You have separate pixel scripts for each domain.</p>
                    </div>
                    <div class="guide_step_list">
                        <ul>
                            <li>Paste the code between the <span class="guide_code_text"><span class="token_punctuation">&lsaquo;</span><span class="token_tag">head</span><span class="token_punctuation">&rsaquo;</span> </span>and <span class="guide_code_text"><span class="token_punctuation">&lsaquo;</span><span class="token_punctuation">/</span><span class="token_tag">head</span><span class="token_punctuation">&rsaquo;</span></span> tags of your website.</li>
                            <li>Make sure it's on every page of your site that you plan to track, capture or display on (in most cases this will be every page of your site).</li>
                        </ul>
                    </div>
                    <div class="guide_step_desc">
                        <p>If you're using a third-party platform (Wordpress, Clickfunnels, Shopify, etc) we have prepared <a href="" target="_blank" class="guide_step_link">specific instructions</a>. But if you know how to install third-party scripts on your websites – you can do it yourself, or google it, or write to us and we will help you <span class="guide_smile"></span></p>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_item">
                        <div class="guide_step_number">
                            <div class="guide_step_number_text">
                                <span>3</span>
                                <span>Step</span>
                            </div>
                        </div>
                        <div class="guide_step_desc">
                            <p>Verify that your pixel is sending data. After you've installed the pixel on your site, let's make sure that it's working correctly.</p>
                        </div>
                        <div class="guide_step_img">
                            <img src="/img/guide2.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="ready_block">
                        <div class="ready_title">Ready to get started?!</div>
                        <div class="ready_text">
                            <p>Now that you've installed your pixel, it’s time to <a href="/admin/guide-step-2">Launch New Campaign!</a></p>
                        </div>
                        <div class="ready_link_next">
                            <a href="/admin/guide-step-2">
                                <span>Next Step</span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
