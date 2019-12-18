@extends('Panel::layouts/admin')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>Languages</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/languages/" class="breadcrumbs_link">Languages</a></li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="add-module-tab active">
                <div class="row">
                    <div class="col-lg-offset-1 col-lg-10">
                        <div class="new_languages_link">
                            <a href="#" id="add_language" class="btn">
                                <span></span>
                                <span>Add language</span>
                            </a>
                            <a href="#" id="add_language_value" class="btn">
                                <span></span>
                                <span>Add Value</span>
                            </a>     
                        </div>
                        <div class="notification_tabs">
                            <div class="notification_tabs_content active">
                              <div class="col-lg-12">
                                  @if(count($languageValues) > 0)
                                    <table class="logs-table">
                                        <tr>
                                            <td>ID</td>
                                            <td>Name</td>    
                                            <td>Slug</td>   
                                            @foreach ($languages as $language)
                                                <td>{{ $language->name }}</td>  
                                            @endforeach     
                                            <td>Edit</td>    
                                            <td>Delete</td>                                                 
                                        </tr>
                                        <?php $counter = 1; ?>
                                        @foreach ($languageValues as $item)
                                            <tr class="item-{{ $counter }}" data-id="{{ $counter }}">
                                                <td class="value-id">{{ $counter }}</td>    
                                                <td class="value-name">{{ $item->name }}</td>
                                                <td class="value-slug">{{ $item->slug }}</td>   
                                                @foreach ($languages as $lang)
                                                    <td class="value-lang" data-id="{{ $lang->id }}">{{ $item->getByLang($item->slug, $lang->id) }}</td>  
                                                @endforeach
                                                <td><a href="#" class="value-edit" data-id="{{ $counter }}" data-slug="{{ $item->slug }}" style="color: #388ae6;">Edit</a></td>  
                                                <td><a href="#" class="value-delete" data-id="{{ $counter }}" data-slug="{{ $item->slug }}" style="color: #388ae6;">Delete</a></td>      
                                            </tr>
                                            <?php $counter++; ?>
                                        @endforeach
                                    </table>
                                  @endif
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>         
        </div>
    </div>
    <div class="add_domain_modal" id="languagePopup">
        <div class="domain_modal_fon"></div>
         <div class="c-domain_modal">
            <div class="domain_modal_title">Add language</div>
            <div class="domain_modal_form">
                <form>
                    <div class="domain_modal_form_row">
                        <label for="user-balance">Name</label>
                        <input type="text" placeholder="Language name" name="language-name" id="language-name">
                    </div>
                    <div class="domain_modal_form_row">
                        <div class="domain_modal_form_btn">
                            <button class="btn" id="addLanguage">Add</button>
                        </div>
                    </div>
                </form>
            </div>
         </div>
    </div>
    <div class="add_domain_modal" id="languageValuePopup">
        <div class="domain_modal_fon"></div>
         <div class="c-domain_modal">
            <div class="domain_modal_title">Add value</div>
            <div class="domain_modal_form">
                <form>
                    <div class="domain_modal_form_row">
                        <label for="user-balance">Value</label>
                        <input type="text" placeholder="Name" name="value-name" id="value-name">
                    </div>
                    <div class="domain_modal_form_row" id="add-val-box">
                        <div class="domain_modal_form_btn">
                            <button class="btn" id="addLanguageValue">Add</button>
                        </div>
                    </div>
                </form>
            </div>
         </div>
    </div>
    <div class="add_domain_modal" id="languageValueEdit">
        <div class="domain_modal_fon"></div>
         <div class="c-domain_modal">
            <div class="domain_modal_title">Edit value</div>
            <div class="domain_modal_form">
                <form>
                    <div class="domain_modal_form_row">
                        <label for="user-balance">Value</label>
                        <input type="text" placeholder="Name" name="edit-value-name" id="edit-value-name">
                        <input type="hidden"  name="edit-value-slug" id="edit-value-slug">
                        <input type="hidden"  name="edit-value-id" id="edit-value-id">                  
                    </div>
                    <div class="domain_modal_form_row" id="edit-val-box">
                        <div class="domain_modal_form_btn">
                            <button class="btn" id="editLanguageValue">Save</button>
                        </div>
                    </div>
                </form>
            </div>
         </div>
    </div> 
    <script type="text/javascript">
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.value-delete').on('click', function(){

            let id = $(this).data('id');
            $('.item-' + id).remove(); 

        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#editLanguageValue').on('click', function(){

            let data = {    
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'name' : $('#edit-value-name').val(),
                'slug' : $('#edit-value-slug').val(),              
                //'id' : $('#edit-value-id').val(),      
                'trans' : {},        
            };

            let id   = $('#edit-value-id').val();
            let list = $('#languageValueEdit .lang-row input');

            for(let l in list) {
                let index = list[l].id;
                let value = list[l].value;
                data['trans'][index] = value;
            }
 
            if ($('#edit-value-name').val().length > 0) {
                $.ajax({
                    type: "POST",
                    url: '/api/languages/value/update',
                    data: data,
                    success: function(result) {
                        if (result !== 'false') {
  
                            $('.item-' + id).find('.value-name').html($('#edit-value-name').val());
                            let list = $('.item-' + id + ' .value-lang');

                            list.each(function(){
                                let id = $(this).data('id');
                                $(this).html(data['trans']['language-' + id]);
                            });

                            $('#languageValueEdit').fadeOut('fast');
                        } else {
                            alert('Error');
                        } 
                    }
                });                
            } else {
                alert('Empty field');
            }
 
            return false;
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.value-edit').on('click', function(){

            let data = { '_token' : $('meta[name="csrf-token"]').attr('content') };
            $('#languageValueEdit .lang-row').remove();
            console.log($(this).data('id'));
            let item_id   = $(this).data('id');
            let item      = $('.item-' + item_id);
            let name      = item.find('.value-name').html();
            let slug      = item.find('.value-slug').html();
            let id        = item.find('.value-id').html();    
            let lang_list = $('.item-' + item_id + ' .value-lang');
            let trans_arr = [];

            lang_list.each(function(){
                let id        = $(this).data('id');
                let html      = $(this).html();
                trans_arr[id] = html;
            });
            /// set 
            $('#edit-value-name').val(name);
            $('#edit-value-slug').val(slug);
            $('#edit-value-id').val(id);

            console.log(trans_arr);

            $.ajax({
                type: "POST",
                url: '/api/languages/list',
                data: data,
                success: function(result) {
                    if (result !== 'false') {
                        for(let k in result) {
                            $('#edit-val-box').before('' +
                                    '<div class="domain_modal_form_row lang-row">' +
                                        '<label for="user-balance">Translate ' + result[k].name + '</label>' +
                                        '<input type="text" name="language-' + result[k].name + '" id="language-' + result[k].id + '" value="' + trans_arr[result[k].id] + '">' +
                                    '</div>' +
                                '');
                        }
                    }
                }
            });

            $('#languageValueEdit').fadeIn('fast', function(){});

            return false;
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#add_language').on('click', function(){
            $('#languagePopup').fadeIn('fast', function(){});
            return false;
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#add_language_value').on('click', function(){

            let data = { '_token' : $('meta[name="csrf-token"]').attr('content') };
            $('#languageValuePopup .lang-row').remove();

            $.ajax({
                type: "POST",
                url: '/api/languages/list',
                data: data,
                success: function(result) {
                    if (result !== 'false') {
                        for(let k in result) {
                            $('#add-val-box').before('' +
                                    '<div class="domain_modal_form_row lang-row">' +
                                        '<label for="user-balance">Translate ' + result[k].name + '</label>' +
                                        '<input type="text" name="language-' + result[k].name + '" id="language-' + result[k].id + '">' +
                                    '</div>' +
                                '');
                        }
                    }
                }
            });

            $('#languageValuePopup').fadeIn('fast', function(){});

            return false;
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#addLanguageValue').on('click', function(){

            let data = {    
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'name' : $('#value-name').val(),
                'trans' : {},        
            };

            let list = $('#languageValuePopup .lang-row input');

            for(let l in list) {
                let index = list[l].id;
                let value = list[l].value;

                data['trans'][index] = value;
            }

            if ($('#value-name').val().length > 0) {
                $.ajax({
                    type: "POST",
                    url: '/api/languages/value',
                    data: data,
                    success: function(result) {
                        $('#languageValuePopup').fadeOut('fast');
                    }
                });                
            } else {
                alert('Empty field');
            }
 
            return false;
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#addLanguage').on('click', function(){

            let data = {    
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'name' : $('#language-name').val()        
            };

            if ($('#language-name').val().length > 0) {
                $.ajax({
                    type: "POST",
                    url: '/api/languages/add',
                    data: data,
                    success: function(result) {
                        $('#languagePopup').fadeOut('fast');
                    }
                });                
            } else {
                alert('Empty field');
            }

            return false;
        });   
    </script>
 
@endsection
