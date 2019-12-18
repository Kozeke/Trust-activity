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
										{{ Form::model($article, array('route' => array('blog.update', $article->id), 'method' => 'PUT')) }}
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
													<textarea class="input-textarea" name="content" placeholder="content" id="content">{!! $article->content !!}</textarea>
												</div>
											</div>	
											<div class="module_add_row">
												<label for="title">Title</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="title" id="title" name="title" value="{{ $article->title }}">
												</div>
											</div>
											<div class="module_add_row">
												<label for="description">Description</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="description" id="description" name="description" value="{{ $article->description }}">
												</div>
											</div>
											<div class="module_add_row">
												<label for="h1">h1</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="h1" id="h1" name="h1" value="{{ $article->h1 }}">
												</div>
											</div>	
											<div class="module_add_row">
												<label for="url">url</label>
												<div class="module_add_row_input">
													<input type="text" placeholder="url" id="url" name="url" value="{{ $article->url }}">
												</div>
											</div>		
											<input type="submit" name="submit" class="link_next" value="Save" />
										{{ Form::close() }}
						                {{ Form::open(array('url' => 'admin/blog/' . $article->id)) }}
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
    <div class="add_domain_modal">
    	<div class="domain_modal_fon"></div>
		 <div class="c-domain_modal">
		 	<div class="domain_modal_title">Сhange balance</div>
		 	<div class="domain_modal_form">
		 		<form>
		 			<div class="domain_modal_form_row">
		 				<label for="user-balance">Balance</label>
		 				<input type="text" placeholder="0" name="user-balance" id="user-balance">
		 				<input type="hidden" placeholder="0" name="user-id" id="user-id">
		 			</div>
		 			<div class="domain_modal_form_row">
		 				<div class="domain_modal_form_btn">
		 					<button class="btn" id="submitBalance">Сhange balance</button>
		 				</div>
		 			</div>
		 		</form>
		 	</div>
		 </div>
    </div>

    <script type="text/javascript">

    	tinymce.init({
		    selector: '#content',
		    theme: 'modern',
		    height: 300,
		    plugins: [
		      'advlist autolink link image lists charmap preview hr anchor pagebreak',
		      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		      'save table paste textcolor'
		    ],
		    content_css: 'css/content.css',
		    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview fullpage | forecolor backcolor'
		  });
	    $('.change_balance').click(function() {
	    	$('#user-balance').val($(this).data('balance'));
	    	$('#user-id').val($(this).data('id'));
			$('.add_domain_modal').addClass('show_modal');

			return false;
	    });

	    $('#submitBalance').click(function() {
	    	var balance = $('#user-balance').val();

			var data = {	
				'_token' : $('meta[name="csrf-token"]').attr('content'),
				'user_id' : $('#user-id').val(),
				'balance' : $('#user-balance').val()		
			};

			$.ajax({
                type: "POST",
                url: '/api/users/balance',
                data: data,
                success: function(result) {
                	if(result == 'true') {
                		$('#balance-' + $('#user-id').val()).html('$' + $('#user-balance').val());
				        $('.add_domain_modal').removeClass('show_modal');
				        $('.question_fon').removeClass('show_fon');
				        $('.question_block_hidden').removeClass('open_question');
                	} else {
                		alert('ошибка');
                	}
                }
            });

	    	return false;
	    });

	    //$('meta[name="csrf-token"]').attr('content')

    </script>

@endsection
