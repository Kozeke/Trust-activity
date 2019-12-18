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
            <li class="breadcrumbs_item active">Edit</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
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
							<form action="/admin/questions/article/{!! $article->id !!}" method="POST" accept-charset="UTF-8">
								{{ csrf_field() }}
			                    {{ Form::hidden('_method', 'PUT') }}	
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
														<label for="content">Content</label>
														<div class="module_add_row_input" style="width: 100%;">
															<textarea class="input-textarea content_textarea" name="content_{{ $language->name }}" placeholder="content" id="content">{{ $article->{'content_'.$language->name} }}</textarea>
														</div>
													</div>	
													<div class="module_add_row">
														<label for="title">Title</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="title" id="title" name="title_{{ $language->name }}" value="{{ $article->{'title_'.$language->name} }}">
														</div>
													</div>
													<div class="module_add_row">
														<label for="description">Description</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="description" id="description" name="description_{{ $language->name }}" value="{{ $article->{'description_'.$language->name} }}">
														</div>
													</div>
													<div class="module_add_row">
														<label for="h1">h1</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="h1" id="h1" name="h1_{{ $language->name }}" value="{{ $article->{'h1_'.$language->name} }}">
														</div>
													</div>	
													<div class="module_add_row">
														<label for="url">url</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="url" id="url" name="url_{{ $language->name }}" value="{{ $article->{'url_'.$language->name} }}">
														</div>
													</div>		
													<div class="module_add_row">
														<label for="url">external url</label>
														<div class="module_add_row_input">
															<input type="text" placeholder="external url" id="external_url" name="externalurl_{{ $language->name }}" value="{{ $article->{'externalurl_'.$language->name} }}">
														</div>
													</div>
													<input type="submit" name="submit" class="link_next" value="Save" />
											</div>
										</div>
									</div>
		                        </div>
		                    @endforeach    
							<input type="hidden" name="categoryid" value="{{ $article->categoryid }}">
							</form>
							<form action="/admin/questions/article/{!! $article->id !!}" method="POST" accept-charset="UTF-8">
								{{ csrf_field() }}
			                    {{ Form::hidden('_method', 'DELETE') }}
			                    {{ Form::submit('Delete', array('class' => 'link_next delete')) }}
							</form>
	                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
 
		  tinymce.init({
		    selector: '.content_textarea',
		    theme: 'modern',
		    height: 300,
		    plugins: [
		      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
		      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		      'save table contextmenu directionality emoticons template paste textcolor'
		    ],
		    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
		  });

    </script>
@endsection
