@extends('Panel::layouts/app')

@section('title', 'Domain - '.$domain->url)
@section('description', 'Domain - '.$domain->name. '('.$domain->url.')')

@section('content')
    @if($domain->deleted_at != null)
        <div class="deleted_blackout">
            <div class="c-notification_disabled_fon">
                <div class="icon_disabled_fon"></div>
                <div class="title_disabled_fon">{!! Helpers::translate('domain-deleted', 'Domain deleted!') !!}</div>
                <div class="text_disabled_fon">The domain will be fully deleted from <br>our database after {{ $domain->deleted_left }} hours.</div>
                <div class="link_disabled_fon">
                    <a href="#" id="domain-page-undelete" data-id="{{ $domain->id }}"><span>{!! Helpers::translate('restore', 'Restore') !!}</span><span></span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="alert-notification" id="alert-notification"><div class="image"></div><p>{!! Helpers::translate('code-copied', 'Code copied') !!}</p></div>
    <div class="admin_header">
        <div class="admin_title domain_title">
            <h1>{{ $domain->name }}</h1>
            <div class="domain_settings">
                <p class="domain_save">
                    <span class="icon_domain_save"></span>
                    <span class="text_domain_save">{!! Helpers::translate('save', 'Save') !!}</span>
                </p>
                <p class="domain_edit">
                    <span class="icon_domain_edit"></span>
                    <span class="text_domain_edit">{!! Helpers::translate('edit', 'Edit') !!}</span>
                </p>
                <p class="domain_delete" data-id="{{ $domain->id }}">
                    <span class="icon_domain_delete"></span>
                    <span class="text_domain_delete">{!! Helpers::translate('delete', 'Delete') !!}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/domains/" class="breadcrumbs_link">{{ Helpers::translate('all-domains', 'All Domains') }}</a></li>
            <li class="breadcrumbs_item active">{{ $domain->url }}</li>
        </ul>
    </div>
     <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
            	<!-- choose block -->
                <div class="col-lg-12 w-platform-block"> 
                		<div class="w-platform_number_text no-padding"><span>1</span> <span>{!! Helpers::translate('choose-your-website-platform', 'Choose your website platform') !!}</span></div>
                		<div class="w-platform-list">
                			<div class="w-platform-item active" data-type="other">
                				<div class="w-platform-title"><span>{!! Helpers::translate('other', 'Other') !!}</span></div>
                			</div>
                			<div class="w-platform-item" data-type="other">
                				<div class="w-platform-title"><span><img src="/img/integration/clickfunnels.svg"></span></div>
                			</div>
                			<div class="w-platform-item" data-type="wordpress">
                				<div class="w-platform-title"><span><img src="/img/integration/wordpress.svg"></span></div>
                			</div>
                			<div class="w-platform-item" data-type="drupal">
                				<div class="w-platform-title"><span><img src="/img/integration/drupal.svg"></span></div>
                			</div>
                			<div class="w-platform-item" data-type="other">
                				<div class="w-platform-title"><span><img src="/img/integration/wix.svg"></span></div>
                			</div>
                			<div class="w-platform-item" data-type="magento">
                				<div class="w-platform-title"><span><img src="/img/integration/magento.svg"></span></div>
                			</div>
                			<div class="w-platform-item" data-type="other">
                				<div class="w-platform-title"><span><img src="/img/integration/webflow.svg"></span></div>
                			</div>
                		</div>
                </div>
                <!-- code block other -->
                <div class="col-lg-12 w-platform-block" id="other"> 
                		<div class="w-platform_number_text no-padding"><span>2</span> <span>{!! Helpers::translate('add-code-on-your-website', 'Add code on your website') !!}</span></div>
                		 <p>{!! Helpers::translate('place-this-code-before-the', 'Place this code before the') !!} <span class="token_tag"><span class="token_tag">&lt;</span>/head<span class="token_tag">&gt;</span></span>{!! Helpers::translate('tag-on-the-page-where-you-want-to', 'tag on the page where you want to capture or display notifications') !!}.</p>
                		 <div class="w-platform-script-block">
            				<code class="code_for_user" id="foo">
                                <span class="token_tag"><span class="token_punctuation">&lt;</span>script</span>
                                <span class="token_type">type</span><span class="token_punctuation">=</span><span class="token_string"><span class="token_punctuation">&quot;</span>text/javascript<span class="token_punctuation">&quot;</span></span>
                                <span class="token_type">src</span><span class="token_punctuation">=</span><span class="token_string"><span class="token_punctuation">&quot;</span>{!! secure_url('/') !!}{{ '/cdn/truster.js?acc='.$domain->hash_key.'' }}<span class="token_punctuation">&quot;</span><span class="token_punctuation">&gt;</span><span class="token_tag"><span class="token_punctuation">&lt;</span><span class="token_punctuation">/</span>script<span class="token_punctuation">&gt;</span></span></span>
                            </code>	
                            <button class="script-block-btn blue btn copy_link">{!! Helpers::translate('copy-code', 'Copy code') !!}</button>
                            <button class="script-block-btn btn" id="send-to-developer-1">{!! Helpers::translate('send-to-developer', 'Send to developer') !!}</button>
                		 </div>
                		 <div id="clipboard-src">{!! secure_url('/') !!}{{ '/cdn/truster.js?acc='.$domain->hash_key.'' }}</div>
                </div>
               <!-- code block cms -->
                <div class="col-lg-12 w-platform-block" id="cms">
                		<div class="w-platform_number_text no-padding"><span>2</span> <span>{!! Helpers::translate('add-code-on-your-website', 'Add code on your website') !!}</span></div>
                		 <p>{!! Helpers::translate('grab-this-code-and-paste-it-inside-code-snippet-box', 'Grab this code and paste it inside code snippet box.') !!} <a href="#" id="show_instruction">{!! Helpers::translate('use-instruction', 'Use instruction') !!} »</a></p>
                		 <div class="w-platform-script-block">
            				<code class="code_for_user" id="foo">
                                <span>{{ $domain->hash_key }}</span> 
                            </code>	
                            <button class="script-block-btn blue btn copy_key">{!! Helpers::translate('copy-code', 'Copy code') !!}</button>
                            <button class="script-block-btn btn" id="send-to-developer-2">{!! Helpers::translate('send-to-developer', 'Send to developer') !!}</button>
                		 </div>
                		 <div id="clipboard-key">{{ $domain->hash_key }}</div>
                </div>
               <!-- code block cms -->
                <div class="col-lg-12 w-platform-block" id="other" style="margin-bottom: 20px;">
                        <div class="w-platform_number_text no-padding"><span>3</span> <span>{!! Helpers::translate('activate-script', 'Activate script') !!}</span></div>
                         <p>{!! Helpers::translate('visit-page-where-your-script-was-installed-so-trust-activity-can-start-tracking-your-website-activity', 'Visit page where your script was installed, so Trust Activity can start tracking your website activity.') !!}</p>
                </div> 
                <!-- waiting data -->
                <div class="col-lg-12 w-platform-block">
                		<div class="w-platform_number_text no-padding"><span>4</span> <span>{!! Helpers::translate('wait-for-data-from-your-website', 'Wait for data from your website') !!}</span></div>
                		 <p>{!! Helpers::translate('a-status-message-will-appear-below-to-let-you-know-when-we-have-detected-your-pixel', 'A status message will appear below to let you know when we have detected your pixel.') !!}</p>
                		 <div class="w-platform-loading"> 
                		 	<div class="w-platform-loading-title">
								<div class="cssload-container">
									<div class="cssload-speeding-wheel"></div>
								</div>
                		 		<span>{!! Helpers::translate('wait-for-data-from-your-website', 'Wait for data from your website') !!}</span>
                		 	</div>
                		 	<span class="success-message">{!! Helpers::translate('congrats-script-has-been-successfully-installed-we-will-redirect-you-now', 'Congrats! Script has been successfully installed! We will redirect you now.') !!}</span>
                		 </div>
                		 <input type="hiddne" id="domain_id" name="" value="{{ $domain->id }}">
                </div>
                <!-- help block -->
                <div class="col-lg-12 w-platform-block">
                    <div class="support_box support_box_domain">
                        <div class="col-lg-6">
                            <div class="other_question_block technical_questions_block">
                                <div class="other_question_icon"></div>
                                <div class="other_question_desc">    
                                    <div class="other_question_title">{!! Helpers::translate('ran-into-problems', 'Ran into problems?') !!}</div>
                                    <div class="other_question_text">{!! Helpers::translate('you-can-find-solution-how-to-install-script-into-your-websites-cms', 'You can find solution how to install script into your website’s CMS  ') !!} <a href="/admin/faq/integrations" target="_blank">{!! Helpers::translate('here', 'here') !!}</a>.</div>
                                </div>
                            </div>
                        </div>  
                        <div class="col-lg-6">
                            <div class="other_question_block no_find_answer_block">
                                <div class="other_question_icon"></div>
                                <div class="other_question_desc">
                                    <div class="other_question_title">{!! Helpers::translate('cant-find-your-answer', 'Can’t find your answer?') !!}</div>
                                    <div class="other_question_text">{!! Helpers::translate('were-here-to-help-speak-with-someone-from-trust-activity', 'We’re here to help. Speak with someone from Trust Activity.') !!} <a href="mailto:support@trustactivity.com">{!! Helpers::translate('contact-us', 'Contact us') !!}<span></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <cmsinstruction></cmsinstruction>

@endsection
