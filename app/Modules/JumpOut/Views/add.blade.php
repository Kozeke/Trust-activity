@extends('JumpOut::layouts/app')

@section('title', Helpers::translate('add-new-campaign', 'Add New jumpout campaign'))
@section('description', Helpers::translate('add-new-campaign', 'Add New jumpout campaign'))

@section('content')
        <div class="admin_header">
            <div class="admin_title">
                <h1>Add new Jump Out</h1>
            </div>
        </div>
        <div class="admin_breadcrumbs">
            <ul class="breadcrumbs_list">
                <li class="breadcrumbs_item"><a href="/admin/domains" class="breadcrumbs_link">All Domains</a></li>
                <li class="breadcrumbs_item"><a href="/admin/domains/{{ $id }}/jumpout" class="breadcrumbs_link">positron-it.ru</a></li>
                <li class="breadcrumbs_item active">Add new Jump Out</li>
            </ul>
        </div>

        <div class="admin_content">
            <div class="container admin_container">
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-8">
                        <div class="module_step" style="text-align: center;">
                            <ul class="module_step_list">
                                @if($data['step'] == 1)
                                    <li class="module_step_item active" id="step-label-1" data-id="1">
                                @else 
                                    <li class="module_step_item" id="step-label-1" data-id="1">
                                @endif
                                    <span class="module_step_text">Beginning</span>
                                    <span class="module_step_number">1</span>
                                </li>
                                @if($data['step'] == 2)
                                    <li class="module_step_item active" id="step-label-2" data-id="2">
                                @else 
                                    <li class="module_step_item" id="step-label-2" data-id="2">
                                @endif
                                    <span class="module_step_text">Design</span>
                                    <span class="module_step_number">2</span>
                                </li>
                                @if($data['step'] == 3)
                                    <li class="module_step_item active" id="step-label-3" data-id="3">
                                @else 
                                    <li class="module_step_item" id="step-label-3" data-id="3">
                                @endif
                                    <span class="module_step_text">Display</span>
                                    <span class="module_step_number">3</span>
                                </li>
                                <!--<li class="module_step_item">-->
                                    <!--<span class="module_step_text">Customize</span>-->
                                    <!--<span class="module_step_number">4</span>-->
                                <!--</li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                @if($data['step'] == 1)
                <div id="step-1" class="add-module-tab active">
                @else
                <div id="step-1" class="add-module-tab">
                @endif
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8">
                            <div class="module_add_block module_rules_block">
                                <form>
                                    <div class="module_add_row">
                                        <div class="question">
                                            <div class="question_icon"></div>
                                            <div class="question_fon"></div>
                                            <div class="question_block_hidden">
                                                <div class="c-question_block">
                                                    <p class="question_block_name">Jump Out name</p>
                                                    <p class="question_block_text">Enter name of  campaign, you will see it in the list of campaigns on domain page.</p>
                                                    <a href="" class="question_block_ok">Got It!</a>
                                                    <a href="" class="question_block_false">Still confused</a>
                                                </div>
                                            </div>
                                        </div>
                                        <label for="campaign_name">Jump Out name</label>
                                        <div class="module_add_row_input">
                                            @if(isset($data['name']))
                                                <input type="text" placeholder="Enter name of Jump Out" id="campaign_name" value="{{ $data['name'] }}">
                                            @else 
                                                <input type="text" placeholder="Enter name of Jump Out" id="campaign_name" value="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="module_add_row">
                                        <div class="question">
                                            <div class="question_icon"></div>
                                            <div class="question_fon"></div>
                                            <div class="question_block_hidden">
                                                <div class="c-question_block"> 
                                                    <p class="question_block_name">Приоритет</p>
                                                    <p class="question_block_text">Приоритет очереди отображение нескольких попапов (чем выше тем лучше)</p>
                                                    <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                                    <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                                </div>
                                            </div> 
                                        </div> 
                                        <label for="conversions">
                                            @if(isset($data['queue']))
                                                <span>Приоритет отображения</span><input type="number" id="queue" placeholder="1" name="queue" value="{{ $data['queue'] }}" class="input_small"><span></span>
                                            @else 
                                                <span>Приоритет отображения</span><input type="number" id="queue" placeholder="1" name="queue" value="1" class="input_small"><span></span>
                                            @endif
                                        </label>
                                    </div> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @if($data['step'] == 2)
                <div id="step-2" class="add-module-tab active">
                @else
                <div id="step-2" class="add-module-tab">
                @endif
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8" style="background-repeat: repeat; background-image: url(/img/redactor_bg.jpg); background-position: top left; padding: 0;">
                            @if(isset($data['template']))
                                <div class="jump_out_block" style="background-color: <?=$data['template']['popup_overlay'];?>">
                            @else 
                                <div class="jump_out_block" style="">
                            @endif
                            @if(isset($data['template']))
                                <?php $position = Helpers::JumpOutPreviewPosition($data['template']['popup_size'], $data['template']['popup_position']); ?>
                                <div class="jump_out_preview <?=$data['template']['popup_size'];?> <?=$data['template']['popup_position'];?>" style="transform: scale(<?=$position['scale'];?>);
                                padding: 20px;
                                border-style: solid;
                                top: <?=$position['top'];?>;
                                bottom: <?=$position['bottom'];?>;
                                left: <?=$position['left'];?>;
                                right: <?=$position['right'];?>;
                                border-width: <?=$data['template']['border_size_count'];?>px;
                                border-color: <?=$data['template']['popup_border'];?>;
                                border-radius: <?=$data['template']['border_size_radius'];?>px;
                                background-color: <?=$data['template']['popup_background'];?>;
                                box-shadow: <?=$data['template']['popup_shadow'];?> 0px 0px <?=$data['template']['shadow_size_count'];?>px 0px;
                                ">
                                    @foreach($data['template']['elements'] as $element)
                                        <div class="jump_out_preview--block {{ $element['id_name'] }}" style="
                                        <?php foreach($element['styles'] as $key => $style): ?>
                                            <?php if($style != ''): ?>
                                                <?php echo $key.': '.$style.';'; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        ">{{ $element['name'] }}</div>
                                    @endforeach
                                </div>
                                @else
                                <div class="jump_out_preview">
                                    <p>Please, click button bellow <br />to design a new Jump Out</p>
                                </div>
                                @endif
                            @if(isset($data['template']))
                                <div class="jump_out_create">
                                    <a href="/admin/domains/{{ $domain->id }}/jumpout/redactor" class="jump_out_create_link" id="moveToRedactor" data-type="edit">Edit Jump Out</a>
                                </div>
                            @else
                                <div class="jump_out_create">
                                    <a href="/admin/domains/{{ $domain->id }}/jumpout/redactor" class="jump_out_create_link" id="moveToRedactor" data-type="start">Start Design Jump Out</a>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if($data['step'] == 3)
                <div id="step-3" class="add-module-tab active">
                @else
                <div id="step-3" class="add-module-tab">
                @endif
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8">
                            <div class="module_rules_title add_url_title">{!! Helpers::translate('where-would-you-like-to-show-your-notifications', 'Where would you like to show your notifications?') !!}</div>
                            <div class="add_url_block">
                                <p class="add_url_text">{!! Helpers::translate('choose-one-or-more-pages-where-you-would-like-to-display-notifications', 'Choose one or more pages where you would like to display notifications.') !!}</p>
                                <form>
                                    <div class="module_add_row">
                                        <div class="question">
                                            <div class="question_icon"></div>
                                            <div class="question_fon"></div>
                                            <div class="question_block_hidden">
                                                <div class="c-question_block"> 
                                                    <p class="question_block_name">{!! Helpers::translate('only-on-the-main-page', 'Only on the main page') !!}</p>
                                                    <p class="question_block_text">{!! Helpers::translate('toggle-this-on-if-you-want-to-show-notifications-only-on-the-main-page', 'Toggle this On, if you want to show notifications only on the main page.') !!}</p>
                                                    <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                                    <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <label>{!! Helpers::translate('only-on-the-main-page', 'Only on the main page') !!}</label>
                                        <div class="check_block">
                                            <input type="radio" id="main_no" name="show_main" checked="checked" value="no">
                                            <label for="main_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                            <input type="radio" id="main_yes" name="show_main" value="yes">
                                            <label for="main_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                            <span class="toggle-outside"><span class="toggle-inside"></span></span>
                                        </div>
                                    </div>
                                    <div class="module_add_row">
                                        <div class="question">
                                            <div class="question_icon"></div>
                                            <div class="question_fon"></div>
                                            <div class="question_block_hidden">
                                                <div class="c-question_block">
                                                    <p class="question_block_name">{!! Helpers::translate('on-all-pages', 'On all pages') !!}</p>
                                                    <p class="question_block_text">{!! Helpers::translate('toggle-this-on-if-you-want-to-show-notifications-on-the-all-pages-of-your-website', 'Toggle this On, if you want to show notifications on the all pages of your website.') !!}</p>
                                                    <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                                    <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                                </div>
                                            </div> 
                                        </div>
                                        <label>{!! Helpers::translate('on-all-pages', 'On all pages') !!}</label>
                                        <div class="check_block">
                                            <input type="radio" id="all_no" name="show_all" checked="checked" value="no">
                                            <label for="all_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                            <input type="radio" id="all_yes" name="show_all" value="yes">
                                            <label for="all_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                            <span class="toggle-outside"><span class="toggle-inside"></span></span>
                                        </div>
                                    </div>          
                                    <div class="module_add_row add_url_row">
                                        <div class="question">
                                            <div class="question_icon"></div>
                                            <div class="question_fon"></div>
                                            <div class="question_block_hidden">
                                                <div class="c-question_block">
                                                    <p class="question_block_name">{!! Helpers::translate('display-url', 'Display URL') !!}</p>
                                                    <p class="question_block_text">{!! Helpers::translate('choose-the-urls-where-you-would-like-to-display-notification', 'Choose the URL(s) where you would like to display notification') !!}</p>
                                                    <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                                    <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <label for="where_show_notifications">{!! Helpers::translate('url', 'URL') !!}</label>
                                        <div class="module_add_row_input">
                                            <input type="text" placeholder="{!! Helpers::translate('example-trustactivitycomsignup', 'Example: trustactivity.com/signup') !!}" name="show url" id="where_show_notifications">
                                        </div>
                                        <button class="add_url_button" id="addShowUrl">{!! Helpers::translate('add', 'Add') !!}</button>
                                        <div class="added_url_list" >
                                            <ul id="show-list">
                                              <!--<li class="added_url_item"><span>positron-it.ru</span><a href="" class="delete_url_item"></a></li>
                                              <li class="added_url_item"><span>google.com</span><a href="" class="delete_url_item"></a></li>
                                              <li class="added_url_item"><span>positron-it.ru/vacancy</span><a href="" class="delete_url_item"></a></li>
                                              <li class="added_url_item"><span>hellloo.com</span><a href="" class="delete_url_item"></a></li>
                                              <li class="added_url_item"><span>positron-it.ru/portfolio</span><a href="" class="delete_url_item"></a></li>-->
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-8">
                        <div class="module_link">
                            <input type="hidden" name="domain" value="{{ $domain->url }}">
                            <input type="hidden" name="domain_id" value="{{ $domain->id }}">
                            <div class="module_link_back"><a href="" class="link_back"><span></span><span>Back</span></a></div>
                            <div class="module_link_next"><a href="" class="link_next"><span>Next</span><span></span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
