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
	<div class="admin_header domain">
		<div class="admin_title domain_title">
			<h1>{{ $domain->name }}</h1>
			<div class="domain_settings">
				<span class="timezone-block">
					<span>Timezone: </span>
					<select class="timezone" id="timezone">
 						@foreach($timezones as $zone)
 							@if(Auth::user()->timezone == $zone['val'])
 								<option value="{!! $zone['val'] !!}" selected="selected">{!! $zone['text'] !!}{!! $zone['city'] !!}</option> 
 							@else 
 								<option value="{!! $zone['val'] !!}">{!! $zone['text'] !!}{!! $zone['city'] !!}</option> 
 							@endif
 						@endforeach
					</select>					
				</span>

 				<span class="domain-settings head" id="domain-settings">
					<img src="/img/dd_settings.svg" class="settings" alt="settings" />
					<span class="settings_text">{{ Helpers::translate('domain-settings', 'Domain settings') }}</span>
				</span>
			</div>
		</div>
	</div>
	<div class="admin_content domain">
		<div class="container admin_container">
			<div class="row">
				<div class="col-lg-12">
					<div class="notification_tabs domain">
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
									<span class="notification_tabs_item_paid_days" id="notifications-paid-days" style="display: none;">Paid days: 0</span>
								</p>
								<div class="inactive_block">
									<p>Jump Out {{ Helpers::translate('module-is-currently-under-development', 'module is currently under development.') }}</p>
								</div>
							</li>
							<li class="notification_tabs_item">
								<p>
									<span class="notification_tabs_item_icon email_icon"></span>
									<span class="notification_tabs_item_name">Email</span>
									<span class="notification_tabs_item_paid_days" id="notifications-paid-days" style="display: none;">Paid days: 0</span>
								</p>
								<div class="inactive_block">
									<p>Email {{ Helpers::translate('module-is-currently-under-development', 'module is currently under development.') }}</p>
								</div>
							</li>
						</ul>

						<div class="notification_tabs_content active">
							<div class="c-notification">
								<div class="new_campaign_link">
									<a href="/admin/domains/{{ $domain->id }}/notification/add" class="btn pink"><span></span><span>{{ Helpers::translate('new-campaign', 'New Campaign') }}</span></a>
								</div> 
								<input type="hidden" name="domainId" value="{{ $domain->id }}">
								<!--<div class="notification_item off">
									<div class="notification_toggle">
										<div class="c-notification_toggle">
											<input type="checkbox"> 
											<label class="checkbox_label">
												<span class="checkbox_label_txt checkbox_label_on">ON</span> 
												<span class="checkbox_toggle"></span> 
												<span class="checkbox_label_txt checkbox_label_off">OFF</span>
											</label>
										</div>
									</div>
									<div class="notification_name">
										<div class="notification_name_text">Amount of visitors viewing page in real-time</div>
										<div class="notification_name_options">
											<p>created: <span>1 minute ago</span></p>
										</div>
									</div> 
									<div class="metrics_block_ex_content currently">
										<div class="module_example_desc">
											<div class="module_example_img">
												<img src="/cdn/img/green_view_icon.svg" atl="" style="width: 44px;">
											</div>
											<div class="module_example_right">
												<div class="module_example_text">
													<p class="module_example_name"><span class="num_marked">315 visitors</span> currently viewing this page</p>
												</div> 
												<div class="module_example_by">
													<p>
														<span class="done"></span>
														<span>by <span class="green_text">Trust Activity</span>
														</span>
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="notification_settings domain">
										<button class="show_more_btn">
											<span class="notification_settings_icon"></span>
											<span>More</span>
										</button>
										<div class="settings_list domain">

											<a class="notification_settings_link metrics_link">
												<span>Metrics</span>
											</a> 
											<a class="notification_settings_link contacts_link">
												<span>Contacts</span>
											</a>

											<a href="/admin/domains/1/notification/271" class="notification_settings_link edit_link">
												<span>Edit</span>
											</a> 
											<a class="notification_settings_link delete_link">
												<span>Delete</span>
											</a>

										</div>
									</div>
								</div>

								<div class="notification_item on">
									<div class="notification_toggle">
										<div class="c-notification_toggle">
											<input type="checkbox"> 
											<label class="checkbox_label">
												<span class="checkbox_label_txt checkbox_label_on">ON</span> 
												<span class="checkbox_toggle"></span> 
												<span class="checkbox_label_txt checkbox_label_off">OFF</span>
											</label>
										</div>
									</div>
									<div class="notification_name">
										<div class="notification_name_text">Amount of visitors viewing page in real-time</div>
										<div class="notification_name_options">
											<p>modified: <span>6 month ago</span></p> <p>shows: <span>1001 times</span></p>
										</div>
									</div> 

									<div class="metrics_block_ex_content">
										<div class="module_example_desc">
											<div class="module_example_img">
												<img src="/cdn/img/congratulations.svg" atl="" style="width: 32px;">
											</div> 
											<div class="module_example_right">
												<div class="module_example_text">
													<p class="module_example_name">A Marketer from Bentleigh East...n</p>
													<p class="module_example_mess">Recently bought trip to India</p>
												</div> 
												<div class="module_example_time">
													<p>2 minutes ago</p>
												</div>
												<div class="module_example_by">
													<p>
														<span class="done"></span>
														<span>by <span class="green_text">Trust Activity</span>
													</span>
												</p>
											</div>
										</div>
									</div>
									<div class="notification_settings domain">
										<button class="show_more_btn">
											<span class="notification_settings_icon"></span>
											<span>More</span>
										</button>
										<div class="settings_list domain">

											<a class="notification_settings_link metrics_link">
												<span>Metrics</span>
											</a> 
											<a class="notification_settings_link contacts_link">
												<span>Contacts</span>
											</a>

											<a href="/admin/domains/1/notification/271" class="notification_settings_link edit_link">
												<span>Edit</span>
											</a> 
											<a class="notification_settings_link delete_link">
												<span>Delete</span>
											</a>

										</div>
									</div>
								</div>-->
								<campaignlistnew></campaignlistnew>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="metrics_block_fon"></div>
		<div class="popup_settings_fon"></div>
		<div class="popup_settings">

			<div class="admin_title domain_title domain_settings_title">
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

			<span class="popup_title">{!! Helpers::translate('domain-settings', 'Domain settings') !!}</span>
				@if($domain->isInstalled)
                    <div class="code_block">
						<div class="code_block_head">
							<div class="code_block_settings">
								<div class="installed_link" style="display: inline-block;">
									<a href="#">
										<span></span>
										<span>{{ Helpers::translate('installed', 'Installed') }}</span>
									</a>
								</div> 
								<div class="code_block_wrapper">
									<div class="copy_link">
										<p data-clipboard-target="#foo">
											<span></span>
											<span>{{ Helpers::translate('copy', 'Copy') }}</span>
										</p>
									</div>
									<div class="api_link"><a href="#"><span></span><span>API</span></a></div>
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
				@else
                    <div class="code_block">
						<div class="code_block_head uninstalled">
							<div class="code_block_settings">
								<div class="installed_link" style="display: inline-block;">
									<a href="#">
										<span></span>
										<span>{{ Helpers::translate('uninstalled', 'Uninstalled') }}</span>
									</a>
								</div> 
								<div class="code_block_wrapper">
									<div class="copy_link">
										<p data-clipboard-target="#foo">
											<span></span>
											<span>{{ Helpers::translate('copy', 'Copy') }}</span>
										</p>
									</div>
									<div class="api_link"><a href="#"><span></span><span>API</span></a></div>
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


				
				<span class="popup_small_title">{!! Helpers::translate('notification-settings', 'Notification settings') !!}</span>

				<div class="customize_block">
					<campaignsettings></campaignsettings>
 
				</div>
		 
			<input type="hidden" name="domain-id" value="{{ $domain->id }}">
				 
		</div>
</div>

	<campaigncontacts></campaigncontacts>
    <campaignmetrics></campaignmetrics>
    <campaignpurchase></campaignpurchase>
@endsection

