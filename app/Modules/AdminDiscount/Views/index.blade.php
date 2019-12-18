@extends('Panel::layouts/admin')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Promo codes</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/promo-codes/" class="breadcrumbs_link">Promo codes</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="add-module-tab active">
              <div class="row">
                  <div class="new_campaign_link">
                    <a href="/admin/promo-codes/create" class="btn">
                      <span></span>
                      <span>Add promo code</span>
                    </a>
                  </div>
                  <div class="col-lg-offset-2 col-lg-8">
                      @if(count($discounts) > 0)
                        <table class="logs-table">
                          <tr>
                            <td>Bonus code</td>
                            <td>Discount</td>                 
                            <td>Type</td>              
                            <td>Limit</td>      
                            <td>Status</td>   
                            <td></td> 
                            <td></td>                                                                                                            
                          </tr>
                        @foreach ($discounts as $discount)
                            <tr>
                              <td>{{ $discount->bonus_code }}</td>
                              <td>{{ $discount->discount }}</td>
                              <td>{{ $discount->type }}</td>
                              <td>{{ $discount->limit }}</td>   
                              <td>{{ $discount->status }}</td>     
                              <td><a href="/admin/promo-codes/{{ $discount->id }}">Edit</a></td>       
                              <td><a href="#" class="delete-discount" data-id="{!! $discount->id !!}">Delete</a></td>                                                          
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
      
      $(document).on('click', '.delete-discount', function(){

        var id   = $(this).data('id');
        var that = $(this);
        var data = {  
          'id' : id,
          '_token' : $('meta[name="csrf-token"]').attr('content'),
        };

        $.ajax({
            type: "POST",
            url: '/admin/promo-codes/delete',
            data: data,
            success: function(result) {
              if (result == 'success') {
                that.parent().parent().remove();
              } else {
                alert('Error. Something went wrong!');
              }
            }
        });

        return false;
      });

    </script>
 
@endsection
