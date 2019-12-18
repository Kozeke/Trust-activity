@extends('Panel::layouts/admin')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Mail settings</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/mail-settings/" class="breadcrumbs_link">Mail settings</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="add-module-tab active">
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="customize_block">
                          <form>
                          	  @if(isset($settings['tenDaysActive']))
                              <div class="module_add_row">
                                  <label>10 days active</label>
                                  <div class="check_block">
                                  	@if($settings['tenDaysActive']['value'] == 1)
                  										<input type="radio" id="tenDaysActive_no" name="tenDaysActive" value="no">
                  										<label for="tenDaysActive_no" class="check_label">Off</label>
                  										<input type="radio" id="tenDaysActive_yes" name="tenDaysActive" checked="checked" value="yes">
                  										<label for="tenDaysActive_yes" class="check_label">On</label>
                                    @else
                  										<input type="radio" id="tenDaysActive_no" name="tenDaysActive" checked="checked" value="no">
                  										<label for="tenDaysActive_no" class="check_label">Off</label>
                  										<input type="radio" id="tenDaysActive_yes" name="tenDaysActive" value="yes">
                  										<label for="tenDaysActive_yes" class="check_label">On</label>
                                  	@endif;
                                      <span class="toggle-outside">
                                          <span class="toggle-inside"></span>
                                      </span>
                                  </div>
                              </div>
                              @endif
                              @if(isset($settings['threeDaysUnActive']))
                              <div class="module_add_row">
                                  <label>1 days unactive</label>
                                  <div class="check_block">
                                  	@if($settings['threeDaysUnActive']['value'] == 1)
                                      <input type="radio" id="threeDaysUnActive_no" name="threeDaysUnActive" value="no">
                                      <label for="threeDaysUnActive_no" class="check_label">Off</label>
                                      <input type="radio" id="threeDaysUnActive_yes" name="threeDaysUnActive" checked="checked" value="yes">
                                      <label for="threeDaysUnActive_yes" class="check_label">On</label>
                                  	@else
                                      <input type="radio" id="threeDaysUnActive_no" name="threeDaysUnActive" checked="checked" value="no">
                                      <label for="threeDaysUnActive_no" class="check_label">Off</label>
                                      <input type="radio" id="threeDaysUnActive_yes" name="threeDaysUnActive" value="yes">
                                      <label for="threeDaysUnActive_yes" class="check_label">On</label>
                                  	@endif;
                                      <span class="toggle-outside">
                                          <span class="toggle-inside"></span>
                                      </span>
                                  </div>
                              </div>  
                              @endif
                              @if(isset($settings['threeDaysLeft']))   
                              <div class="module_add_row">
                                  <label>3 days left</label>
                                  <div class="check_block">
                                  	@if($settings['threeDaysLeft']['value'] == 1)
                                      <input type="radio" id="threeDaysLeft_no" name="threeDaysLeft" value="no">
                                      <label for="threeDaysLeft_no" class="check_label">Off</label>
                                      <input type="radio" id="threeDaysLeft_yes" name="threeDaysLeft" checked="checked" value="yes">
                                      <label for="threeDaysLeft_yes" class="check_label">On</label>
                                  	@else
                                      <input type="radio" id="threeDaysLeft_no" name="threeDaysLeft" checked="checked" value="no">
                                      <label for="threeDaysLeft_no" class="check_label">Off</label>
                                      <input type="radio" id="threeDaysLeft_yes" name="threeDaysLeft" value="yes">
                                      <label for="threeDaysLeft_yes" class="check_label">On</label>
                                  	@endif;
                                      <span class="toggle-outside">
                                          <span class="toggle-inside"></span>
                                      </span>
                                  </div>
                              </div>
                              @endif
                              @if(isset($settings['twelveHoursNoScript']))   
                              <div class="module_add_row">
                                  <label>12 hours no script</label>
                                  <div class="check_block">
                                    @if($settings['twelveHoursNoScript']['value'] == 1)
                                      <input type="radio" id="twelveHoursNoScript_no" name="twelveHoursNoScript" value="no">
                                      <label for="twelveHoursNoScript_no" class="check_label">Off</label>
                                      <input type="radio" id="twelveHoursNoScript_yes" name="twelveHoursNoScript" checked="checked" value="yes">
                                      <label for="twelveHoursNoScript_yes" class="check_label">On</label>
                                    @else
                                      <input type="radio" id="twelveHoursNoScript_no" name="twelveHoursNoScript" checked="checked" value="no">
                                      <label for="twelveHoursNoScript_no" class="check_label">Off</label>
                                      <input type="radio" id="twelveHoursNoScript_yes" name="twelveHoursNoScript" value="yes">
                                      <label for="twelveHoursNoScript_yes" class="check_label">On</label>
                                    @endif;
                                      <span class="toggle-outside">
                                          <span class="toggle-inside"></span>
                                      </span>
                                  </div>
                              </div>
                              @endif    
                          </form>
                      </div>
                      @if($pagination)
                      <div class="pagination pagination-admin" style="margin-top: 10px;">
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
                      @if(count($logs) > 0)
                        <table class="logs-table">
                          <tr>
                            <td>User email</td>
                            <td>Type</td>
                            <td>Created at</td>                 
                          </tr>
                        @foreach ($logs as $item)
                            <tr>
                                <td>{{ $item->user }}</td>
                                <td>
                                @if ($item->type == 'tenDaysActive')
                                  {{ '10 days active' }}
                                @elseif ($item->type == 'threeDaysUnActive')
                                  {{ '1 day unactive' }}
                                @elseif ($item->type == 'threeDaysLeft')
                                  {{ '3 days left' }}
                                @elseif ($item->type == 'twelveHoursNoScript')
                                  {{ '12 hours no script' }}
                                @else
                                  {{ $item->type }}
                                @endif
                                </td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                        @endforeach
                        </table>
                      @endif
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
            </div>         
        </div>
    </div>

    <script type="text/javascript">
    
    	$(document).on('change', 'input[type="radio"]', function() {

    		var name = $(this).attr('name');
    		var item = $('input[name=' + name + ']:checked');

			var data = {	
				'name' : $(this).attr('name'),
				'value' : item.val(),
				'_token' : $('meta[name="csrf-token"]').attr('content'),
			};

			$.ajax({
	            type: "POST",
	            url: '/admin/api/mail/change-status',
	            data: data,
	            success: function(result) {
	            }
	        });
    	});

    </script>
 
@endsection
