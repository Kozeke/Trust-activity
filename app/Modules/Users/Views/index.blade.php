@extends('Panel::layouts/admin')

@section('content')


    <div class="admin_header">
        <div class="admin_title">
            <h1>Users</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/users/" class="breadcrumbs_link">Users</a></li>
        </ul>
    </div>
    <div class="admin_content">
    	<div class="container admin_container" id="admin_app">
    		<users></users>
    	</div>

        <!--<div class="container admin_container">



            <div class="row">
                <div class="col-lg-offset-1 col-lg-10">
	                @if($pagination)
	                <div class="pagination pagination-admin">
	                    <ul>
	                        @if($pagination['current'] > 1)
	                            <? $prev = $pagination['current'] - 1; ?>
	                            <li class="pagination_item"><a href="?page={!! $prev !!}" class="pagination_link_arrow pagination_arrow_prev"> < </a>
	                        @endif
	                        @for($i = 1; $i < $pagination['total'] +1; $i++)
	                            @if($pagination['current'] == $i)
	                                <li class="pagination_item"><a href="?page={!! $i !!}" class="pagination_link active">{!! $i !!}</a></li>
	                            @else
	                                <li class="pagination_item"><a href="?page={!! $i !!}" class="pagination_link">{!! $i !!}</a></li>
	                            @endif
	                        @endfor
	                        @if($pagination['current'] < $pagination['total'])
	                            <? $next = $pagination['current'] + 1; ?>
	                            <li class="pagination_item"><a href="?page={!! $next !!}" class="pagination_link_arrow pagination_arrow_next"> > </a></li>
	                        @endif
	                    </ul>
	                </div>
	                @endif
                    <div class="notification_tabs">
                        <div class="notification_tabs_content active">
                                @foreach($users as $user)
	                                <div class="notification_item">
	                                    <div class="notification_name">
	                                        <div class="notification_name_text">{{ $user->email }}</div>
	                                        <div class="notification_name_options">
	                                        	<p>registered: <span>{{ $user->created_at }}</span></p>
	                                            <p>balance: <span id="balance-{{ $user->id }}">${{ $user->balance }} (${{ $user->referral_balance}})</span></p>                                        
	                                            <div class="domain-user-list">
		                                            @foreach($user->userDomains($user->id) as $domain)
		                                            	<p>{{ $domain->name }} ({{ $domain->count }})</p>
		                                            @endforeach
		                                        </div>
	                                        </div>
	                                    </div>
	                                    <div class="notification_settings">
	                                        <div class="c-notification_settings">
	                                            <a href="/admin/users/enter/{{ $user->id }}" class="notification_settings_link contacts_link"><span class="notification_settings_icon"></span><span>Enter as user</span></a>
	                                            <a href="" class="notification_settings_link metrics_link change_balance" data-id="{{ $user->id }}" data-balance="{{ $user->balance }}"><span class="notification_settings_icon"></span><span>Change balance</span></a>
	                                            {{ $user->role }}
	                                            @if($user->role == 2)
	                                            	<a href="/admin/users/promote/{{ $user->id }}" class="notification_settings_link metrics_link" data-id="{{ $user->id }}" data-balance="{{ $user->balance }}"><span class="notification_settings_icon"></span><span><span style="color: #e39891; vertical-align: top;">Demote</span> to user</span></a>  
	                                            @else
	                                            	<a href="/admin/users/promote/{{ $user->id }}" class="notification_settings_link metrics_link" data-id="{{ $user->id }}" data-balance="{{ $user->balance }}"><span class="notification_settings_icon"></span><span><span style="color: #32BA7C; vertical-align: top;">Promote</span> to partner</span></a>
	                                            @endif
	                                        </div>
	                                    </div>
	                                </div>
                                @endforeach
                        </div>
                    </div>
	                @if($pagination)
	                <div class="pagination pagination-admin">
	                    <ul>
	                        @if($pagination['current'] > 1)
	                            <? $prev = $pagination['current'] - 1; ?>
	                            <li class="pagination_item"><a href="?page={!! $prev !!}" class="pagination_link_arrow pagination_arrow_prev"> < </a>
	                        @endif
	                        @for($i = 1; $i < $pagination['total'] +1; $i++)
	                            @if($pagination['current'] == $i)
	                                <li class="pagination_item"><a href="?page={!! $i !!}" class="pagination_link active">{!! $i !!}</a></li>
	                            @else
	                                <li class="pagination_item"><a href="?page={!! $i !!}" class="pagination_link">{!! $i !!}</a></li>
	                            @endif
	                        @endfor
	                        @if($pagination['current'] < $pagination['total'])
	                            <? $next = $pagination['current'] + 1; ?>
	                            <li class="pagination_item"><a href="?page={!! $next !!}" class="pagination_link_arrow pagination_arrow_next"> > </a></li>
	                        @endif
	                    </ul>
	                </div>
	                @endif
                </div>
            </div>
        </div>-->
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
    	
	    $(document).on('click', '.change_balance', function() {
	    	$('#user-balance').val($(this).data('balance'));
	    	$('#user-id').val($(this).data('id'));
			$('.add_domain_modal').fadeIn('show_modal');

			return false;
	    });

	    $(document).on('click', '#submitBalance', function() {
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
                		$('#balance-' + $('#user-id').val()).parent().parent().parent().parent().find('.change_balance').data('balance', '$' + $('#user-balance').val());
                		$('#balance-' + $('#user-id').val()).html('$' + $('#user-balance').val());
				        $('.add_domain_modal').fadeOut('show_modal');
				        $('.question_fon').fadeOut('show_modal');
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
