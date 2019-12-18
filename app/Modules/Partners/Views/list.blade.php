@extends('Panel::layouts/admin')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Partners request</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/withdraw/" class="breadcrumbs_link">Affilate withdraw</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="add-module-tab active">
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      @if(count($users) > 0)
                        <table class="logs-table">
                          <tr>
                            <td>User email</td>
                            <td>Status</td>    
                            <td>Action</td>                 
                          </tr>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $item->user($item->user_id)->email }}</td>
                                @if($item->status == 0)
                                    <td style="color: #ff9d00;">pending</td> 
                                @elseif($item->status == 1)
                                    <td style="color: #32BA7C;">accepted</td> 
                                @elseif($item->status == 2)
                                    <td style="color: #e39891;">decline</td> 
                                @endif       
                                <td>
                                    @if($item->status == 0)
                                        <form action="/admin/partners-list/accept" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="submit" name="submit" value="Accept" style="width: 80px; margin-bottom: 5px;" />                                        
                                        </form>
                                        <form action="/admin/partners-list/decline" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="submit" name="submit" value="Decline" style="width: 80px;" />                                        
                                        </form>
                                    @endif    
                                </td>             
                            </tr>
                        @endforeach
                        </table>
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
