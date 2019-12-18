@extends('Panel::layouts/admin')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>FAQ categories</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/questions" class="breadcrumbs_link">FAQ categories</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
                	<div class="new_campaign_link">
                		<a href="/admin/questions/create" class="btn">
                			<span></span>
                			<span>Add category</span>
                		</a>
                	</div>
                    <div class="notification_tabs">
                        <div class="notification_tabs_content active">
                            @foreach($categories as $category)
                                <div class="notification_item">
                                    <div class="notification_name">
                                        <div class="notification_name_text"><a href="{{ '/admin/questions/'.$category->id }}" >{{ $category->name_en }}</a></div>
                                    </div>
                                    <div class="notification_settings">
                                        <div class="c-notification_settings">
                                            <a href="/admin/questions/edit/{{ $category->id }}" class="notification_settings_link contacts_link"><span class="notification_settings_icon"></span><span>Edit</span></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
