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
										<form action="/admin/blog" method="POST">
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
													<input type="text" placeholder="name" id="name" name="name" value="{{ old('name') }}">
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
												<label for="url">icon url</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="icon url" id="icon_url" name="icon_url" value="{{ old('icon_url') }}">
												</div>
											</div>	
											{{ csrf_field() }}
											<input type="submit" name="submit" class="link_next" value="Add" />
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
 
 
@endsection
