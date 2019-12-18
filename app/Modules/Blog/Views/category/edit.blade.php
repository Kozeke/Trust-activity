@extends('Panel::layouts/admin')

@section('content')


    <div class="admin_header">
        <div class="admin_title">
            <h1>Blog categories</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/blog/" class="breadcrumbs_link">Blog categories</a></li>
            <li class="breadcrumbs_item active">Edit</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="notification_tabs">
                        <div class="notification_tabs_content active">
							<div class="row">
								<div class="col-lg-offset-2 col-lg-8" style="width: 100%; margin: 0;">
									<div class="module_add_block">
										<form action="/admin/blog/{!! $category->id !!}" method="POST" accept-charset="UTF-8">
											{{ csrf_field() }}
											{{ Form::hidden('_method', 'PUT') }}
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
													<input type="text" placeholder="name" id="name" name="name" value="{{ $category->name }}">
												</div>
											</div>
											<div class="module_add_row">
												<label for="title">Title</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="title" id="title" name="title" value="{{ $category->title }}">
												</div>
											</div>
											<div class="module_add_row">
												<label for="description">Description</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="description" id="description" name="description" value="{{ $category->description }}">
												</div>
											</div>
											<div class="module_add_row">
												<label for="h1">h1</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="h1" id="h1" name="h1" value="{{ $category->h1 }}">
												</div>
											</div>	
											<div class="module_add_row">
												<label for="url">url</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="url" id="url" name="url" value="{{ $category->url }}">
												</div>
											</div>		
											<div class="module_add_row">
												<label for="url">icon url</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="icon_url" id="icon_url" name="icon_url" value="{{ $category->icon_url  }}">
												</div>
											</div>	
											<input type="submit" name="submit" class="link_next" value="Save" />
										</form>
										<form action="/admin/blog/{!! $category->id !!}" method="POST" accept-charset="UTF-8">
											{{ csrf_field() }}
											{{ Form::hidden('_method', 'DELETE') }}
						                    {{ Form::submit('Delete', array('class' => 'link_next delete')) }}
						                {{ Form::close() }}
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
