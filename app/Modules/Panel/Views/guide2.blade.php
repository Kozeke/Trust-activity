@extends('Panel::layouts/app')

@section('title', 'Guide: step 2')
@section('description', 'Guide: step 2')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Step 2: Launch New Campaign</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/guide" class="breadcrumbs_link">Guide</a></li>
            <li class="breadcrumbs_item active">Step 2: Launch New Campaign</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_title">
                        <h2>Learn how easily and safely you can launch new campaign.</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_caption">
                        <div class="guide_step_caption_desc">
                            <p>It is time to get started with TrustActivity’s social proof notifications.</p>
                            <p>The first you need to do – is click on the button &ldquo;+ New Campaign&rdquo; in Notifications Tab.</p>
                        </div>
                        <div class="guide_step_img">
                            <img src="/img/guide6.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_item">
                        <div class="guide_step_number">
                            <div class="guide_step_number_text">
                                <span>1</span>
                                <span>Step: Beginning</span>
                            </div>
                        </div>
                        <div class="guide_step_desc">
                            <p>Enter Campaign name and message that will be displayed on the notification. If you want to use your own image – you can add it in the form below.</p>
                        </div>
                        <div class="guide_step_img">
                            <img src="/img/guide3.png" alt="">
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
                                <span>Step: Setup Capture URL(s)</span>
                            </div>
                        </div>
                        <div class="guide_step_desc">
                            <p>Choose the URL(s) where you will be capturing your leads from. In order to capture conversions, this page MUST have an email input field.</p>
                        </div>
                        <div class="guide_step_img">
                            <img src="/img/guide4.png" alt="">
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
                                <span>Step: Enter Display URL(s)</span>
                            </div>
                        </div>
                        <div class="guide_step_desc">
                            <p>Choose the URL(s) where you would like to display notifications. Manually add any display URL(s) that don't auto-populate by pasting the page into the input box and clicking the "Add" button.</p>
                        </div>
                        <div class="guide_step_img">
                            <img src="/img/guide5.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="guide_step_item">
                        <div class="guide_step_number">
                            <div class="guide_step_number_text">
                                <span>4</span>
                                <span>Step: Customize notifications (optional)</span>
                            </div>
                        </div>
                        <div class="guide_step_desc">
                            <p>You can easily customize the notification by using the toggle options and input boxes.</p>
                        </div>
                        <div class="guide_step_img">
                            <img src="/img/guide2-6.png" alt="">
                        </div>
                        <div class="guide_step_note">
                            <p>NOTE: The highest-converting settings are set by default.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-offset-1 col-lg-10">
                        <div class="launch_block">
                            <div class="launch_title">Launch it, kickback and watch your conversions go viral!</div>
                            <div class="launch_text">Click the green <span>Finish</span> button to make the campaign live. <br />Your notifications should start appearing on your website once someone opts in on your page.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-offset-1 col-lg-10">
                        <div class="not_working_block">
                            <div class="not_working_title">Still not working?</div>
                            <div class="not_working_text">If your notifications are still not displaying, then please <a href="/admin/faq" target="_blank">get more help here</a>.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
