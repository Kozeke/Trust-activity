@extends('Panel::layouts/admin')

@section('content')


    <div class="admin_header">
        <div class="admin_title">
            <h1>FAQ categories</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/questions/" class="breadcrumbs_link">FAQ categories</a></li>
            <li class="breadcrumbs_item active">Add</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                	<div class="new_campaign_link">
                	</div>
                	@if(count($languages) > 1)
                		<?php $first = 0; ?>
                		@foreach($languages as $language)
                    			@if($first == 0)
                    				<?php $first = 1; ?>
		                        	<a href="#" class="notification_tab_switch active" data-name="{{ $language->name }}">{{ $language->name }}</a>
                    			@else 
		                        	<a href="#" class="notification_tab_switch" data-name="{{ $language->name }}">{{ $language->name }}</a>
                    			@endif
                		@endforeach
                	@endif
                    <div class="notification_tabs">
                    	@if(count($languages) > 1)
                    		<?php $first = 0; ?>
                    		<form action="/admin/questions-category" method="POST" enctype="multipart/form-data">
                    		@foreach($languages as $language)
                    			@if($first == 0)
                    				<?php $first = 1; ?>
		                        	<div class="notification_tabs_content active {{ 'notification_tabs_content_'.$language->name }}">
                    			@else 
		                        	<div class="notification_tabs_content {{ 'notification_tabs_content_'.$language->name }}">
                    			@endif
									<div class="row">
										<div class="col-lg-offset-2 col-lg-8" style="width: 100%; margin: 0;">
											<div class="module_add_block">
													@if ($errors->any())
													    <div class="alert alert-danger errors">
													        <ul>
													            @foreach ($errors->all() as $error)
													                <li>{{ $error }}</li>
													            @endforeach
													        </ul>
													    </div>
													@endif
													<div class="module_add_row">
														<label for="title">Name</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="name" id="name" name="name_{{ $language->name }}" value="{{ old('name_'.$language->name) }}">
														</div>
													</div>
													<div class="module_add_row">
														<label for="title">Title</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="title" id="title" name="title_{{ $language->name }}" value="{{ old('title_'.$language->name) }}">
														</div>
													</div>
													<div class="module_add_row">
														<label for="description">Description</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="description" id="description" name="description_{{ $language->name }}" value="{{ old('description_'.$language->name) }}">
														</div>
													</div>
													<div class="module_add_row">
														<label for="h1">h1</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="h1" id="h1" name="h1_{{ $language->name }}" value="{{ old('h1_'.$language->name) }}">
														</div>
													</div>	
													<div class="module_add_row">
														<label for="url">url</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="url" id="url" name="url_{{ $language->name }}" value="{{ old('url_'.$language->name) }}">
														</div>
													</div>	
													<div class="module_add_row">
														<label for="url">external url</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="external url" id="external_url" name="externalurl_{{ $language->name }}" value="{{ old('external_url_'.$language->name) }}">
														</div>
													</div>	
													<div class="module_add_row">
														<label for="url">icon url</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="icon url" id="icon_url" name="iconurl_{{ $language->name }}" value="{{ old('iconurl_'.$language->name) }}">
														</div>
													</div>	
													{{ csrf_field() }}
													<input type="submit" name="submit" class="link_next" value="Add" />
											</div>
										</div>
									</div>
		                        </div>	                        
                    		@endforeach
							</form>	
                    	@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
 
 
@endsection
