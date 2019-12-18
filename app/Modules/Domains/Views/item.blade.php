@extends('Panel::layouts/app')

@section('title', 'Domain - '.$domain->url)
@section('description', 'Domain - '.$domain->name. '('.$domain->url.')')

@section('content')
    @if($domain->deleted_at != null)
        <div class="deleted_blackout">
            <div class="c-notification_disabled_fon">
                <div class="icon_disabled_fon"></div>	 
                <div class="title_disabled_fon">{{ Helpers::translate('domain-deleted-2', 'Domain deleted!') }}</div>
                <div class="text_disabled_fon">{{ Helpers::translate('the-domain-will-be-fully-deleted-from-our-database-after', 'The domain will be fully deleted from our database after') }} {{ $domain->deleted_left }} {{ Helpers::translate('hours', 'hours') }}.</div>
                <div class="link_disabled_fon">
                    <a href="#" id="domain-page-undelete" data-id="{{ $domain->id }}"><span>{{ Helpers::translate('restore', 'Restore') }}</span><span></span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if($domain->getActivePurchaseStatus($domain->id) == 2)
        <div class="deleted_blackout">
            <div class="c-notification_disabled_fon"> 
                <div class="icon_disabled_fon"></div>    
                <div class="title_disabled_fon">{{ Helpers::translate('you-have-reached-traffic-limits', 'You have reached traffic limits!') }}</div>
                <div class="text_disabled_fon">{{ Helpers::translate('please-activate-next-package', 'Please, activate next package with more limits') }}</div>
                <div class="link_disabled_fon">
                    <a href="#" id="domain-plan-update" data-id="{{ $domain->id }}"><span>{{ Helpers::translate('update-plan', 'Update plan') }}</span><span></span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="alert-notification" id="alert-notification"><div class="image"></div><p>{{ Helpers::translate('code-copied', 'Code copied') }}</p></div>
    <div class="admin_header">
        <div class="admin_title domain_title">
            <h1>{{ $domain->name }}</h1>
            <input type="hidden" name="d_url" id="d_url" value="{{ $domain->url }}">
            <div class="domain_settings">
                <p class="domain_save">
                    <span class="icon_domain_save"></span>
                    <span class="text_domain_save">{{ Helpers::translate('save', 'Save') }}</span>
                </p>
                <p class="domain_edit">
                    <span class="icon_domain_edit"></span>
                    <span class="text_domain_edit">{{ Helpers::translate('edit', 'Edit') }}</span>
                </p>
                <p class="domain_delete" data-id="{{ $domain->id }}">
                    <span class="icon_domain_delete"></span>
                    <span class="text_domain_delete">{{ Helpers::translate('delete', 'Delete') }}</span>
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
                <div class="col-lg-offset-1 col-lg-10">
                    @if($domain->isInstalled)
                        <div class="code_block">
                            <div class="code_block_head">
                                <p class="code_block_head_name">{{ Helpers::translate('script-is-installed-into', 'Script is installed into') }} <span class="blue_text">{{ $domain->url }}</span></p>
                                <div class="view_code"> 
                                    <a href="" class="view_code_link"><span></span><span>{{ Helpers::translate('view-code', 'View code') }}</span></a>
                                    <a href="" class="hide_code_link opacity"><span></span><span>{{ Helpers::translate('hide-code', 'Hide code') }}</span></a>
                                </div>
                                <div class="code_block_settings">
                                    <div class="installed_link" style="display: inline-block;"><a href="#"><span></span><span>{{ Helpers::translate('installed', 'Installed') }}</span></a></div>
                                    <div class="copy_link"><p data-clipboard-target="#foo"><span></span><span>{{ Helpers::translate('copy', 'Copy') }}</span></p></div>
                                    <div class="api_link"><a href="#"><span></span><span>API</span></a></div>
                                </div>
                            </div>
                            <div class="code_block_content" style="display: none;">
                                <code class="code_for_user" id="foo">
                                    <span class="token_tag"><span class="token_punctuation">&lt;</span>script</span>
                                    <span class="token_type">type</span><span class="token_punctuation">=</span><span class="token_string"><span class="token_punctuation">&quot;</span>text/javascript<span class="token_punctuation">&quot;</span></span>
                                    <span class="token_type">src</span><span class="token_punctuation">=</span><span class="token_string"><span class="token_punctuation">&quot;</span>{!! secure_url('/') !!}{{ '/cdn/truster.js?acc='.$domain->hash_key.'' }}<span class="token_punctuation">&quot;</span><span class="token_punctuation">&gt;</span><span class="token_tag"><span class="token_punctuation">&lt;</span><span class="token_punctuation">/</span>script<span class="token_punctuation">&gt;</span></span></span>
                                </code>
                                <div class="copy_link copy_link_abs"><a href="#"><span></span><span>{{ Helpers::translate('copy', 'Copy') }}</span></a></div>
                            </div>
                        </div>
                    @else
                        <div class="code_block big_size">   
                            <div class="code_block_head">
                                <p class="code_block_head_name">{{ Helpers::translate('сopy-and-paste-this-JS-code-snippet-in-the', 'Copy and paste this JS code snippet in the') }}
                                    <span class="dark-red_text"><span class="token_punctuation">&lt;</span>/head<span class="token_punctuation">&gt;</span></span> {{ Helpers::translate('of-the-page-that-you-want-to-track-or-display-notifications-on', 'of the page that you want to track or display notifications on') }}.</p> 
                                <div class="code_block_settings">
                                    <div class="as_table">
                                        <div class="as_table_cell">
                                            <div class="uninstalled_link"><a href="#"><span></span><span>{{ Helpers::translate('uninstalled', 'Uninstalled') }}</span></a></div>
                                            <div class="copy_link"><p data-clipboard-target="#foo"><span></span><span>{{ Helpers::translate('copy', 'Copy') }}</span></p></div>
                                            <div class="api_link"><a href="#"><span></span><span>API</span></a></div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="code_block_content">
                                <code class="code_for_user" id="foo">
                                    <span class="token_tag"><span class="token_punctuation">&lt;</span>script</span>
                                    <span class="token_type">type</span><span class="token_punctuation">=</span><span class="token_string"><span class="token_punctuation">&quot;</span>text/javascript<span class="token_punctuation">&quot;</span></span>
                                    <span class="token_type">src</span><span class="token_punctuation">=</span><span class="token_string"><span class="token_punctuation">&quot;</span>{!! secure_url('/') !!}{{ '/cdn/truster.js?acc='.$domain->hash_key.'' }}<span class="token_punctuation">&quot;</span><span class="token_punctuation">&gt;</span><span class="token_tag"><span class="token_punctuation">&lt;</span><span class="token_punctuation">/</span>script<span class="token_punctuation">&gt;</span></span></span>
                                </code>
                                <div class="copy_link copy_link_abs"><a href="#"><span></span><span>{{ Helpers::translate('copy', 'Copy') }}</span></a></div>
                            </div>
                        </div>
                    @endif
                    <div class="api_popup_fon"></div>
                    <div class="api_popup">
                        <div class="link_bonus_text">
                            <input type="text" value="{!! $domain->hash_key !!}" class="link_bonus_code" disabled="disabled">
                            <p id="api_link" class="copy_link_bonus"></p>                     
                        </div>
                    </div>
                    <div id="clipboard-src">{!! secure_url('/') !!}{{ '/cdn/truster.js?acc='.$domain->hash_key.'' }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="notification_tabs">
                        <ul>
                            <li class="notification_tabs_item active">
                                <p>
                                    <span class="notification_tabs_item_icon notification_icon"></span>
                                    <span class="notification_tabs_item_name">{{ Helpers::translate('notifications', 'Notifications') }}</span>
                                    <span class="notification_tabs_item_paid_days" id="notifications-paid-days" style="display: none;">{{ Helpers::translate('loading', 'Loading') }}</span>
                                </p>
                            </li>
                            <li class="notification_tabs_item">
                                <p>
                                    <span class="notification_tabs_item_icon jump_out_icon"></span>
                                    <span class="notification_tabs_item_name">Jump Out</span>
                                </p>
                                <div class="inactive_block">
                                    <p>Jump Out {{ Helpers::translate('module-is-currently-under-development', 'module is currently under development.') }}</p>
                                </div>
                            </li>
                            <li class="notification_tabs_item">
                                <p>
                                    <span class="notification_tabs_item_icon email_icon"></span>
                                    <span class="notification_tabs_item_name">Email</span>
                                </p>
                                <div class="inactive_block">
                                    <p>Email {{ Helpers::translate('module-is-currently-under-development', 'module is currently under development.') }}</p>
                                </div>
                            </li>
                        </ul>
                        <div class="notification_tabs_content active">
                            <div class="c-notification">
                                <div class="new_campaign_link">
                                    <a href="/admin/domains/{{ $domain->id }}/notification/add" class="btn"><span></span><span>{{ Helpers::translate('new-campaign', 'New Campaign') }}</span></a>
                                    <a class="domain-settings" href="/admin/domains/{{ $domain->id }}/notification/settings">{{ Helpers::translate('domain-settings', 'Domain settings') }}<img src="/img/d_settings.svg" alt="settings" /></a>
                                </div> 
                                <input type="hidden" name="domainId" value="{{ $domain->id }}">
                                <campaignlist></campaignlist>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="support_box support_box_domain">
                        <div class="col-lg-6">
                            <div class="other_question_block technical_questions_block">
                                <div class="other_question_icon"></div>
                                <div class="other_question_desc">
                                    <div class="other_question_title">{{ Helpers::translate('ran-into-problems', 'Ran into problems?') }}</div>
                                    <div class="other_question_text">{{ Helpers::translate('you-can-find-solution-how-to-install-script-into-your-websites-cms', 'You can find solution how to install script into your website’s CMS') }} <a href="/admin/faq/integrations" target="_blank">{{ Helpers::translate('here', 'here') }}</a>.</div>
                                </div>
                            </div>
                        </div>  
                        <div class="col-lg-6">
                            <div class="other_question_block no_find_answer_block" style="border: none;"> 
                                <div class="other_question_icon"></div>
                                <div class="other_question_desc">
                                    <div class="other_question_title">{{ Helpers::translate('cant-find-your-answer', 'Can’t find your answer?') }}</div>
                                    <div class="other_question_text">{{ Helpers::translate('were-here-to-help-speak-with-someone-from-trust-activity', 'We’re here to help. Speak with someone from Trust Activity.') }} <a href="mailto:support@trustactivity.com">{{ Helpers::translate('contact-us', 'Contact us') }}<span></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="domain-id" value="{{ $domain->id }}">
        </div>
    </div>
    <campaigncontacts></campaigncontacts>
    <campaignmetrics></campaignmetrics>
    <campaignpurchase></campaignpurchase>
 

@endsection
