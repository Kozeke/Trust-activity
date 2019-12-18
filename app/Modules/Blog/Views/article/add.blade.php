@extends('Panel::layouts/admin')

@section('content')


    <div class="admin_header">
        <div class="admin_title">
            <h1>Blog</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/blog/" class="breadcrumbs_link">Blog</a></li>
            <li class="breadcrumbs_item active">Add</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                	<div class="new_campaign_link">
                	</div>
                    <div class="notification_tabs">
                        <div class="notification_tabs_content active">
							<div class="row">
								<div class="col-lg-offset-2 col-lg-8" style="width: 100%; margin: 0;">
									<div class="module_add_block">
										<form action="/admin/blog/create-article" method="POST" enctype="multipart/form-data">
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
													<textarea class="input-textarea" name="content" placeholder="content" id="content">{{ old('content') }}</textarea>
												</div>
											</div>	
											<div class="module_add_row">
												<label for="title">Title</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="title" id="title" name="title" value="{{ old('title') }}">
												</div>
											</div>
											<div class="module_add_row">
												<label for="description">Description</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="description" id="description" name="description" value="{{ old('description') }}">
												</div>
											</div>
											<div class="module_add_row">
												<label for="h1">h1</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="h1" id="h1" name="h1" value="{{ old('h1') }}">
												</div>
											</div>	
											<div class="module_add_row">
												<label for="url">url</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="url" id="url" name="url" value="{{ old('url') }}">
												</div>
											</div>		
											<div class="module_add_row">
												<label for="conversion">Conversion</label>
												<div class="module_add_row_input">
													<input type="number" placeholder="conversion" id="conversion" name="conversion" value="{{ old('conversion') }}">
												</div>
											</div>		
											<div class="module_add_row">
												<label for="image">Image</label>
												<div class="module_add_row_input">
													<input type="file" placeholder="image" id="image" name="image" value="{{ old('image') }}" style="display: block;">
												</div>
											</div>														
											{{ csrf_field() }}
											<input type="hidden" name="category_id" value="{{ $category->id }}" />
											<input type="submit" name="submit" class="link_next" value="Save" />
										</form>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
 
		  tinymce.init({
		    selector: '#content',
		    theme: 'modern',
		    height: 300,
		    plugins: [
		      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
		      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		      'save table contextmenu directionality emoticons template paste textcolor'
		    ],
		    content_css: 'css/content.css',
		    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
		  });

    </script>

@endsection
