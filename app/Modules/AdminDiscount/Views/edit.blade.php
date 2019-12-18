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
                          <form method="POST" action="/admin/promo-codes/update/{!! $item->id !!}">
                            <div class="module_add_row">
                                <label for="campaign_name">Bonus code</label>
                                <div class="module_add_row_input">
                                    <input type="text" placeholder="Bonus code" id="bonus_code" name="bonus_code" value="{!! $item->bonus_code !!}">
                                </div>
                            </div>
                            <div class="module_add_row">
                                <label for="campaign_name">Discount</label>
                                <div class="module_add_row_input">
                                    <input type="text" placeholder="Discount" id="discount" name="discount" value="{!! $item->discount !!}">
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <input type="submit" id="submit" class="link_next" value="Save" />
                          </form>
                      </div>
                  </div>
              </div>
            </div>         
        </div>
    </div>

@endsection
