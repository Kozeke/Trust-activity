@extends('Panel::layouts/admin')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Add bonus code</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/promo-codes/" class="breadcrumbs_link">Bonus code</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="add-module-tab active">
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="customize_block">
                          <form method="POST" action="/admin/promo-codes">
                            <div class="module_add_row">
                                <label for="campaign_name">Bonus code</label>
                                <div class="module_add_row_input">
                                    <input type="text" placeholder="Bonus code" id="bonus_code" name="bonus_code" value="" style="width: 330px;">
                                    <button class="link_next" id="generate_code" style="display: inline-block;vertical-align: top;margin-left: 10px;margin-top: 2px;">Generate</button>
                                </div>
                            </div>
                            <div class="module_add_row">
                                <label for="campaign_name">Discount</label>
                                <div class="module_add_row_input">
                                    <input type="number" placeholder="Discount" id="discount" name="discount" value="">
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <input type="submit" id="submit" class="link_next" value="submit" />
                          </form>
                      </div>
                  </div>
              </div>
            </div>         
        </div>
    </div>

    <script type="text/javascript">
      
      $(document).on('click', '#generate_code', function(){

        var data = {  
          '_token' : $('meta[name="csrf-token"]').attr('content'),
        };

        $.ajax({
                type: "POST",
                url: '/admin/promo-codes/get-code',
                data: data,
                success: function(result) {
                  $('input[name="bonus_code"]').val(result);
                }
            });

        return false;
      });

    </script>

@endsection
