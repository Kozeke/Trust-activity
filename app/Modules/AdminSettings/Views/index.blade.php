@extends('Panel::layouts/admin')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Admin settings</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/settings/" class="breadcrumbs_link">Admin settings</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="add-module-tab active">
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="customize_block">
                          <form>
                              <div class="module_add_row">
                                  <label>Site under construction</label>
                                  <div class="check_block">
                                  	@if($settings['underConstruction']['value'] == 1)
                  										<input type="radio" id="underConstruction_no" name="underConstruction" value="no">
                  										<label for="underConstruction_no" class="check_label">Off</label>
                  										<input type="radio" id="underConstruction_yes" name="underConstruction" checked="checked" value="yes">
                  										<label for="underConstruction_yes" class="check_label">On</label>
                                    @else
                  										<input type="radio" id="underConstruction_no" name="underConstruction" checked="checked" value="no">
                  										<label for="underConstruction_no" class="check_label">Off</label>
                  										<input type="radio" id="underConstruction_yes" name="underConstruction" value="yes">
                  										<label for="underConstruction_yes" class="check_label">On</label>
                                  	@endif;
                                      <span class="toggle-outside">
                                          <span class="toggle-inside"></span>
                                      </span>
                                  </div>
                              </div>
                          </form>
                      </div>
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
