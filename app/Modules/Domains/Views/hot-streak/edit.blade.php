@extends('Panel::layouts/app')

@section('title', Helpers::translate('edit-campaign', 'Edit Campaign'))
@section('description', Helpers::translate('edit-campaign', 'Edit Campaign'))

@section('content')
    <div class="module_example_block edit-info-block">
      <div class="image"></div>
      <span data-change="{!! Helpers::translate('you-have-unsaved-changes', 'You have unsaved changes') !!}" data-default="{!! Helpers::translate('no-changes', 'No changes') !!}">{!! Helpers::translate('no-changes', 'No changes') !!}</span>
      <a href="" class="edit-info-save" id="save-updates">{!! Helpers::translate('save', 'Save') !!}</a> 
    </div>
    <div class="dashboard_modal_preloader" id="campaign-preloader" style="display: none;"></div>
    <div id="alert-notification" class="alert-notification"><div class="image"></div><p>{!! Helpers::translate('changes-saved', 'Changes saved') !!}</p></div>
    <div class="admin_header">
        <div class="admin_title">
            <h1>{!! Helpers::translate('edit-campaign', 'Edit Campaign') !!}</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/domains" class="breadcrumbs_link">{!! Helpers::translate('all-domains', 'All Domains') !!}</a></li>
            <li class="breadcrumbs_item"><a href="/admin/domains/{{ $domain->id }}" class="breadcrumbs_link">{{ $domain->url }}</a></li>
            <li class="breadcrumbs_item active">{!! Helpers::translate('edit-campaign', 'Edit Campaign') !!}</li>
        </ul>
    </div>
    <div class="admin_content">
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8">
                    <div class="module_step">
                        <ul class="module_step_list">
                            <li class="module_step_item active active_prev" id="step-label-1" data-id="1">
                                <span class="module_step_text">{!! Helpers::translate('beginning', 'Beginning') !!}</span>
                                <span class="module_step_number">1</span>
                            </li>
                            <li class="module_step_item active active_prev" id="step-label-2" data-id="2">
                                <span class="module_step_text">{!! Helpers::translate('capture', 'Capture') !!}</span>
                                <span class="module_step_number">2</span>
                            </li>
                            <li class="module_step_item active active_prev" id="step-label-3" data-id="3">
                                <span class="module_step_text">{!! Helpers::translate('display', 'Display') !!}</span>
                                <span class="module_step_number">3</span>
                            </li>
                            <li class="module_step_item active active_prev" id="step-label-4" data-id="4">
                                <span class="module_step_text">{!! Helpers::translate('customize', 'Customize') !!}</span>
                                <span class="module_step_number">4</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--<div class="row">
              <div class="col-lg-offset-2 col-lg-8">
                <div class="module_example_block edit-info-block">
                  <a href="/admin/domains/<?//=$module->domain_id;?>" class="edit-info-back">{!! Helpers::translate('back', 'Back') !!}</a>
                  <span>Изменений нет</span>
                  <a href="" class="edit-info-save" id="save-updates">{!! Helpers::translate('save', 'Save') !!}</a> 
                </div>
              </div>
            </div>-->
            <div class="add-module-tab active" id="step-1">
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="module_example_block">
                          <div class="module_example_title">
                              <p>{!! Helpers::translate('example', 'Example') !!}</p>
                              <div class="module_example_arrow"></div>
                          </div>
                          <div class="module_example_content">
                              <div class="module_example_desc">
                                  <div class="module_example_img">
                                  @if($module->image == 'map')
                                    <img src="/cdn/img/map.svg" atl="">
                                  @elseif($module->image == 'party')
                                    <img src="/cdn/img/party.svg" atl="">
                                  @elseif($module->image == 'discount')
                                    <img src="/cdn/img/discount.svg" atl="">
                                  @elseif($module->image != '')
                                    <img src="{!! $module->image !!}" atl="">
                                  @else
                                    <img src="/img/module_img.png" atl="">
                                  @endif
                                  </div>
                                  <div class="module_example_right">
                                      <div class="module_example_text">
                                          <?php if(isset($module->fake_city) && count($module->fake_city) > 0): ?>
                                            <p class="module_example_name">A Marketer {!! Helpers::translate('from', 'from') !!} {!! $module->fake_city[0] !!}</p>
                                          <?php else: ?>
                                            <p class="module_example_name">A Marketer {!! Helpers::translate('from', 'from') !!} Bentleigh East Bentleigh East</p>
                                          <?php endif; ?>
                                          <p class="module_example_mess" id="module_example_mess" data-placeholder="Recently signed up for Trust Activity">{!! Helpers::translate('message', 'Message') !!}</p>
                                      </div>
                                      <div class="module_example_time">
                                          <p>2 {!! Helpers::translate('minutes-ago', 'minutes ago') !!}</p>
                                      </div>
                                      <div class="module_example_by">
                                          <p><span class="done"></span><span>by <span class="green_text">Trust Activity</span></span></p>
                                      </div>
                                  </div>
                              </div>
                              <div class="module_example_sing">
                                  <p>{!! Helpers::translate('fill-the-form-below-and-see-how-it-will-looks-like', 'Fill the form below and see how it will looks like') !!}</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="module_add_block">
                          <form>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('campaign-name', 'Campaign name') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('that-is-how-your-campaign-will-show-in-the-list-of-campaigns-on-notification-tab', 'That is how your campaign will show in the list of campaigns on notification tab.') !!}</p>
                                              <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="campaign_name">{!! Helpers::translate('campaign-name', 'Campaign name') !!}</label>
                                  <div class="module_add_row_input">
                                    <input type="text" placeholder="{!! Helpers::translate('enter-name-of-campaign', 'Enter name of campaign') !!}" id="campaign_name" name="name" data-value="{{ $module->name }}" value="{{ $module->name }}">
                                    <span class="success_icon"></span>
                                  </div>
                              </div>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('message', 'Message') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('the-main-text-of-the-proof-notification-only-36-symbols-is-available', 'The main text of the proof notification. Only 36 symbols is available.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="message">{!! Helpers::translate('message', 'Message') !!}</label>
                                  <div class="module_add_row_input">
                                    <input type="text" placeholder="{!! Helpers::translate('recently-signed-up-for-trust-activity', 'Recently signed up for Trust Activity') !!}" id="message" name="message" value="{{ $module->message }}" data-value="{{ $module->message }}">
                                    <span class="success_icon"></span>
                                    <p class="input_sing"><span id="message-string-length">36</span> {!! Helpers::translate('characters-only', 'characters only') !!}</p>
                                  </div>
                              </div>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">Display a custom image</p>
                                              <p class="question_block_text">You can use your own image on notification. Visit link below for nice looking icons.</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="https://icons8.com" target="_blank" class="question_block_false">Icon8.com</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label>Display a custom image</label>
                                  <label class="label_file">
                                      <input type="file" id="file">
                                      <span>Choose file</span>
                                  </label>
                                  <p class="name_file">No file</p>
                                  <div class="icon-block">
                                    <?php print_r($module->image); ?>
                                    @if($module->image == 'map')
                                      <div class="icon-elem" data-name="custom" style="display: none;"><img id="custom-image" src="/img/custom.jpg"></div>  
                                      <div class="icon-elem active" data-name="map"><img src="/cdn/img/map.svg"></div>  
                                      <div class="icon-elem" data-name="discount"><img src="/cdn/img/discount.svg"></div>  
                                      <div class="icon-elem" data-name="party"><img src="/cdn/img/party.svg"></div>  
                                    @elseif($module->image == 'discount')
                                      <div class="icon-elem" data-name="custom" style="display: none;"><img id="custom-image" src="/img/custom.jpg"></div>  
                                      <div class="icon-elem" data-name="map"><img src="/cdn/img/map.svg"></div>  
                                      <div class="icon-elem active" data-name="discount"><img src="/cdn/img/discount.svg"></div>  
                                      <div class="icon-elem" data-name="party"><img src="/cdn/img/party.svg"></div>  
                                    @elseif($module->image == 'party')
                                      <div class="icon-elem" data-name="custom" style="display: none;"><img id="custom-image" src="/img/custom.jpg"></div>  
                                      <div class="icon-elem" data-name="map"><img src="/cdn/img/map.svg"></div>  
                                      <div class="icon-elem" data-name="discount"><img src="/cdn/img/discount.svg"></div>  
                                      <div class="icon-elem active" data-name="party"><img src="/cdn/img/party.svg"></div>  
                                    @elseif($module->image != '')
                                      <div class="icon-elem active" data-name="custom"><img id="custom-image" src="{!! $module->image !!}"></div>  
                                      <div class="icon-elem" data-name="map"><img src="/cdn/img/map.svg"></div>  
                                      <div class="icon-elem" data-name="discount"><img src="/cdn/img/discount.svg"></div>  
                                      <div class="icon-elem" data-name="party"><img src="/cdn/img/party.svg"></div>    
                                    @else
                                      <div class="icon-elem" data-name="custom" style="display: none;"><img id="custom-image" src="/img/custom.jpg"></div>  
                                      <div class="icon-elem active" data-name="map"><img src="/cdn/img/map.svg"></div>  
                                      <div class="icon-elem" data-name="discount"><img src="/cdn/img/discount.svg"></div>  
                                      <div class="icon-elem" data-name="party"><img src="/cdn/img/party.svg"></div>                   
                                    @endif
                                  </div>
                              </div> 
                          </form>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="module_rules_title">{!! Helpers::translate('display-rules', 'Display rules') !!}</div>
                      <div class="module_rules_block mb35">
                          <form>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('display-the-last', 'Display the last') !!}...</p>
                                              <p class="question_block_text">{!! Helpers::translate('how-many-last-activities-will-be-shown-after-reaching-limit-notifications-will-start-showing-from-beginning', 'How many last activities will be shown. After reaching limit, notifications will start showing from beginning.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="conversions">
                                      <span>{!! Helpers::translate('display-the-last', 'Display the last') !!}</span>
                                      <input type="number" id="conversions" placeholder="20" name="conversions" value="{{ $module->conversions }}" data-value="{{ $module->conversions }}" class="input_small"><span>{!! Helpers::translate('conversions', 'conversions.') !!}</span>
                                  </label>
                              </div>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('only-show-conversions-from-the-last', 'Only show conversions from the last') !!}...</p>
                                              <p class="question_block_text">{!! Helpers::translate('if-you-dont-want-to-show-old-notifications-change-this-limit', 'If you don’t want to show old notifications - change this limit.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="days">
                                      <span>{!! Helpers::translate('only-show-conversions-from-the-last', 'Only show conversions from the last') !!}</span>
                                      <input type="number" name="days" id="days" placeholder="7" value="{{ $module->days }}" data-value="{{ $module->days }}" class="input_small"><span>{!! Helpers::translate('days', 'days.') !!}</span>
                                  </label>
                              </div>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('show-all-conversions-as-anonymous', 'Show all conversions as anonymous') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('toggle-yes-if-you-dont-want-to-show-real-names-of-your-visitors-we-are-using-gravatar-for-capturing-names', 'Toggle YES if you don’t want to show real names of your visitors. We are using Gravatar for capturing names.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label>{!! Helpers::translate('show-all-conversions-as-anonymous', 'Show all conversions as anonymous') !!}</label>
                                  <div class="check_block">
                                      @if($module->show_conversions == 'no')
                                        <input type="radio" id="show_no" name="show_conversions" checked="checked" value="no" data-value="{{ $module->show_conversions }}">
                                        <label for="show_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                        <input type="radio" id="show_yes" name="show_conversions" value="yes" data-value="{{ $module->show_conversions }}">
                                        <label for="show_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                      @else 
                                        <input type="radio" id="show_no" name="show_conversions" value="no" data-value="{{ $module->show_conversions }}">
                                        <label for="show_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                        <input type="radio" id="show_yes" name="show_conversions" checked="checked" value="yes" data-value="{{ $module->show_conversions }}">
                                        <label for="show_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                      @endif
                                      <span class="toggle-outside">
                                          <span class="toggle-inside"></span>
                                      </span>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="module_rules_title fake_module_rules">
                        <div class="question">
                          <div class="question_icon"></div>
                          <div class="question_fon"></div>
                          <div class="question_block_hidden">
                              <div class="c-question_block">
                                 <p class="question_block_name">{!! Helpers::translate('fake-activity', 'Fake activity') !!}</p>
                                  <p class="question_block_text">{!! Helpers::translate('toggle-yes-if-you-dont-have-enough-activity-on-your-website-and-want-to-use-fake-notifications', 'Toggle YES if you don’t have enough activity on your website and want to use fake notifications.') !!}</p>
                                  <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                  <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                              </div>
                          </div>
                        </div>
                        <p class="module_rules_name">{!! Helpers::translate('fake-activity', 'Fake activity') !!}</p>
                        <div class="check_block">
                        @if($module->fake == 'yes')
                          <input type="radio" id="fake_no" name="fake" value="no" data-value="{{ $module->fake }}">
                          <label for="fake_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                          <input type="radio" id="fake_yes" name="fake" checked="checked" value="yes" data-value="{{ $module->fake }}">
                          <label for="fake_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                        @else
                          <input type="radio" id="fake_no" name="fake" checked="checked" value="no" data-value="{{ $module->fake }}">
                          <label for="fake_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                          <input type="radio" id="fake_yes" name="fake" value="yes" data-value="{{ $module->fake }}">
                          <label for="fake_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                        @endif
                          <span class="toggle-outside">
                              <span class="toggle-inside"></span>
                          </span>
                        </div>
                      </div>
                        @if($module->fake == 'yes')
                          <div class="module_rules_block mb35 fake_module_body" style="display: block;">
                        @else
                          <div class="module_rules_block mb35 fake_module_body">
                        @endif
                          <form>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('city-from', 'City from') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('specify-the-time-interval-within-which-fakes-will-be-generated', 'You can define several different cities for truthfulness.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="translate-someone">{!! Helpers::translate('city-from', 'City from') !!}</label>
                                  <div class="module_add_row_input">
                                    <input type="text" placeholder="{!! Helpers::translate('moscow-new-york-etc', 'Moscow, New York etc...') !!}" id="fake_city" name="fake_city" value="">
                                  </div>
                                  <button id="addFakeCity" class="add_url_button">{!! Helpers::translate('add', 'Add') !!}</button>
                                  <div class="added_url_list">
                                    <?php 
                                      $fake_city_data = '';;
                                      foreach ($module->fake_city as $city_e) {
                                        if($city_e != '') $fake_city_data .= $city_e.';';
                                      }
                                      $fake_city_data = substr($fake_city_data, 0, -1);
                                    ?>
                                    <ul id="fakecity-list" data-value="<?=$fake_city_data;?>">
                                        @foreach($module->fake_city as $city)
                                          @if($city != '')
                                            <li class="added_url_item"><span>{{ $city }}</span><a href="#" class="delete_url_item"></a></li>
                                          @endif
                                        @endforeach  
                                    </ul>
                                  </div>
                              </div>
                              <div class="module_add_row">
                                <div class="question">
                                  <div class="question_icon"></div>
                                  <div class="question_fon"></div>
                                  <div class="question_block_hidden">
                                    <div class="c-question_block">
                                      <p class="question_block_name">{!! Helpers::translate('time-from', 'Time from') !!}</p>
                                      <p class="question_block_text">{!! Helpers::translate('specify-the-time-interval-within-which-fakes-will-be-generated', 'Specify the time interval within which fakes will be generated.') !!}</p>
                                      <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                      <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                    </div>
                                  </div>
                                </div>
                                <label for="time-from">
                                  <span>{!! Helpers::translate('time-from', 'Time from') !!}</span>
                                  <input type="number" id="time-from" placeholder="10" name="time-from" value="{{ $module->time_from }}" class="input_small" data-value="{{ $module->time_from }}">
                                  <select name="time-from-type" id="time-from-type" data-value="{{ $module->time_from_type }}">
                                    <option value="m" <? if ($module->time_from_type == 'm') echo 'selected'; ?> >{!! Helpers::translate('minutes', 'Minutes') !!}</option>
                                    <option value="h" <? if ($module->time_from_type == 'h') echo 'selected'; ?> >{!! Helpers::translate('hours-2', 'Hours') !!}</option>
                                    <option value="d" <? if ($module->time_from_type == 'd') echo 'selected'; ?> >{!! Helpers::translate('days-2', 'Days') !!}</option>                                   
                                  </select>
                                </label>
                              </div>
                              <div class="module_add_row">
                                <div class="question">
                                  <div class="question_icon"></div>
                                  <div class="question_fon"></div>
                                  <div class="question_block_hidden">
                                    <div class="c-question_block">
                                      <p class="question_block_name">{!! Helpers::translate('time-to', 'Time to') !!}</p>
                                      <p class="question_block_text">{!! Helpers::translate('specify-the-time-interval-within-which-fakes-will-be-generated', 'Specify the time interval within which fakes will be generated.') !!}</p>
                                      <a href="" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                      <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                    </div>
                                  </div>
                                </div>
                                <label for="time-to">
                                  <span>{!! Helpers::translate('time-to', 'Time to') !!}</span>
                                  <input type="number" id="time-to" placeholder="30" name="time-to" value="{{ $module->time_to }}" class="input_small" data-value="{{ $module->time_to }}">
                                  <select name="time-to-type" id="time-to-type" data-value="{{ $module->time_to_type }}">
                                    <option value="m" <? if ($module->time_to_type == 'm') echo 'selected'; ?> >{!! Helpers::translate('minutes', 'Minutes') !!}</option>
                                    <option value="h" <? if ($module->time_to_type == 'h') echo 'selected'; ?> >{!! Helpers::translate('hours-2', 'Hours') !!}</option>
                                    <option value="d" <? if ($module->time_to_type == 'd') echo 'selected'; ?> >{!! Helpers::translate('days-2', 'Days') !!}</option>                                  
                                  </select>
                                </label>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="module_rules_title language_module_rules">
                        <p class="module_rules_name">{!! Helpers::translate('language', 'Language') !!}</p>
                        <div class="check_block">
                          @if($module->translate_someone != '' || $module->translate_from != '')
                            <input type="radio" id="language_no" name="language" value="no" data-value="yes">
                            <label for="language_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                            <input type="radio" id="language_yes" name="language" checked="checked" value="yes" data-value="yes">
                            <label for="language_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                          @else
                            <input type="radio" id="language_no" name="language" checked="checked" value="no" data-value="no">
                            <label for="language_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                            <input type="radio" id="language_yes" name="language" value="yes" data-value="no">
                            <label for="language_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                          @endif
                          <span class="toggle-outside">
                              <span class="toggle-inside"></span>
                          </span>
                        </div>
                      </div>
                      @if($module->translate_someone != '' || $module->translate_from != '')
                        <div class="module_add_block language_module_body" style="display: block;">
                      @else
                        <div class="module_add_block language_module_body"> 
                      @endif
                          <form>
                              <div class="module_add_row">
                                  <label for="translate-someone">{!! Helpers::translate('translate-someone', "Translate 'Someone'") !!}</label>
                                  <div class="module_add_row_input">
                                    <input type="text" placeholder="{!! Helpers::translate('leave-them-blank-if-you-prefer-to-keep-them-in-english', 'Leave them blank if you prefer to keep them in English') !!}" id="translate-someone" name="translate-someone" value="{{ $module->translate_someone }}" data-value="{{ $module->translate_someone }}">
                                  </div>
                              </div>
                              <div class="module_add_row">
                                  <label for="translate-from">{!! Helpers::translate('translate-from', "Translate 'From'") !!}</label>
                                  <div class="module_add_row_input">
                                    <input type="text" placeholder="{!! Helpers::translate('leave-them-blank-if-you-prefer-to-keep-them-in-english', 'Leave them blank if you prefer to keep them in English') !!}" id="translate-from" name="translate-from" value="{{ $module->translate_from }}" data-value="{{ $module->translate_from }}">
                                  </div>
                              </div>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('locale', 'Locale') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('this-option-is-designed-to-correctly-translate-time-information', 'This option is designed to correctly translate time information.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="locale">{!! Helpers::translate('locale', 'Locale') !!}</label>
                                  <div class="module_add_row_input">
                                    <select name="locale" id="locale" data-value="{{ $module->locale }}">
                                      <option value="en" <?php if($module->locale == 'en')  echo 'selected'; ?> >{!! Helpers::translate('english', 'English') !!}</option>
                                      <option value="de" <?php if($module->locale == 'de')  echo 'selected'; ?> >{!! Helpers::translate('german', 'German') !!}</option>
                                      <option value="it" <?php if($module->locale == 'it')  echo 'selected'; ?> >{!! Helpers::translate('italian', 'Italian') !!}</option>   
                                      <option value="el" <?php if($module->locale == 'el')  echo 'selected'; ?> >{!! Helpers::translate('greek', 'Greek') !!}</option>
                                      <option value="ru" <?php if($module->locale == 'ru')  echo 'selected'; ?> >{!! Helpers::translate('russian', 'Russian') !!}</option>
                                      <option value="tr" <?php if($module->locale == 'tr')  echo 'selected'; ?> >{!! Helpers::translate('turkish', 'Turkish') !!}</option>
                                    </select>
                                  </div>
                              </div>                          
                          </form>
                      </div>
                  </div>
              </div>      
            </div>
            <div class="add-module-tab" id="step-2">
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="module_rules_title add_url_title">{!! Helpers::translate('where-are-you-capturing-your-leads', 'Where are you capturing your leads?') !!}</div>
                      <div class="add_url_block">
                          <p class="add_url_text">{!! Helpers::translate('enter-one-or-more-urls-where-you-are-capturing-conversions-this-page-must-have-an-email-form-field-and-your-pixels-installed', 'Enter one or more URLs where you are capturing conversions. This page must have an email form field and your pixels installed.') !!}</p>
                          <form>
                              <div class="module_add_row add_url_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('capture-url', 'Capture URL') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('choose-the-urls-where-you-will-be-capturing-your-leads-from-in-order-to-capture-conversions-this-page-must-have-an-email-input-field', 'Choose the URL(s) where you will be capturing your leads from. In order to capture conversions, this page MUST have an email input field.') !!}</p>
                                              <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="url_name">{!! Helpers::translate('url', 'URL') !!}</label>
                                  <div class="module_add_row_input">
                                      <input type="text" placeholder="{!! Helpers::translate('example-trustactivitycommain', 'Example: trustactivity.com/main') !!}" id="url_name" name="capture url" >
                                      <span class="success_icon"></span>
                                  </div>
                                  <button class="add_url_button" id="addCaptureUrl">{!! Helpers::translate('add', 'Add') !!}</button>

                                  <div class="added_url_list">
                                      <?php 
                                        $url_c_data = '';
                                        foreach ($module->capture as $url_c_e) {
                                          $url_c_data .= $url_c_e->url.';';
                                        }
                                        $url_c_data = substr($url_c_data, 0, -1);
                                      ?>
                                      <ul id="capture-list" data-value="<?=$url_c_data;?>">
                                        @foreach($module->capture as $url_c)
                                          <li class="added_url_item"><span>{{ $url_c->url }}</span><a href="#" class="delete_url_item"></a></li>
                                        @endforeach
                                      </ul>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
            </div>
            <div class="add-module-tab" id="step-3">
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
                                      <a href="/admin/guide-step-2" class="question_block_false" target="_blank">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                    </div>
                                  </div>
                                </div>
                                <label>{!! Helpers::translate('only-on-the-main-page', 'Only on the main page') !!}</label>
                                <div class="check_block">
                                  @if($module->show_main == 'no')
                                    <input type="radio" id="main_no" name="show_main" checked="checked" value="no" data-value="no">
                                    <label for="main_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                    <input type="radio" id="main_yes" name="show_main" value="yes" data-value="no">
                                    <label for="main_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    <span class="toggle-outside"><span class="toggle-inside"></span></span>
                                  @else 
                                    <input type="radio" id="main_no" name="show_main" value="no" data-value="yes">
                                    <label for="main_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                    <input type="radio" id="main_yes" name="show_main" checked="checked" value="yes" data-value="yes">
                                    <label for="main_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    <span class="toggle-outside"><span class="toggle-inside"></span></span>
                                  @endif
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
                                      <a href="/admin/guide-step-2" class="question_block_false" target="_blank">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                    </div>
                                  </div>
                                </div>
                                <label>{!! Helpers::translate('on-all-pages', 'On all pages') !!}</label>
                                <div class="check_block">
                                  @if($module->show_all == 'no')
                                    <input type="radio" id="all_no" name="show_all" checked="checked" value="no" data-value="no">
                                    <label for="all_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                    <input type="radio" id="all_yes" name="show_all" value="yes" data-value="no">
                                    <label for="all_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    <span class="toggle-outside"><span class="toggle-inside"></span></span>
                                  @else 
                                    <input type="radio" id="all_no" name="show_all" value="no" data-value="yes">
                                    <label for="all_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                    <input type="radio" id="all_yes" name="show_all" checked="checked" value="yes" data-value="yes">
                                    <label for="all_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    <span class="toggle-outside"><span class="toggle-inside"></span></span>
                                  @endif
                                </div>
                              </div>   
                              @if($module->show_main == 'yes' || $module->show_all == 'yes') 
                                <div class="module_add_row add_url_row disabled">
                              @else 
                                <div class="module_add_row add_url_row">
                              @endif
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
                                      <span class="success_icon"></span>
                                  </div>
                                  <button class="add_url_button" id="addShowUrl">{!! Helpers::translate('add', 'Add') !!}</button>
                                  <div class="added_url_list" >
                                    <?php 
                                      $url_d_data = '';;
                                      foreach ($module->display as $url_d_e) {
                                        $url_d_data .= $url_d_e->url.';';
                                      }
                                      $url_d_data = substr($url_d_data, 0, -1);
                                    ?>
                                    <ul id="show-list" data-value="<?=$url_d_data;?>">
                                        @foreach($module->display as $url_d)
                                          <li class="added_url_item"><span>{{ $url_d->url }}</span><a href="#" class="delete_url_item"></a></li>
                                        @endforeach
                                      </ul>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
            </div>
            <div class="add-module-tab" id="step-4">
              <div class="row">
                  <div class="col-lg-offset-2 col-lg-8">
                      <div class="module_rules_title customize_title">{!! Helpers::translate('you-can-make-any-additional-adjustments-below', 'You can make any additional adjustments below.') !!}</div>
                      <div class="customize_sign">{!! Helpers::translate('if-you-are-ready-to-start-now-just-click', 'If you are ready to start now just click') !!} <span>{!! Helpers::translate('finish', 'Finish') !!}</span> {!! Helpers::translate('at-the-bottom', 'at the bottom.') !!}</div>
                      <div class="customize_block">
                          <p class="add_url_text customize_text">{!! Helpers::translate('send-visitors-to-a-specific-url-when-they-click-a-notification', 'Send visitors to a specific url when they click a notification') !!}</p>
                          <form>
                              <div class="module_add_row customize_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('send-to-url', 'Send to URL') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('choose-the-url-where-your-visitors-will-be-redirected-after-they-have-clicked-on-the-notification', 'Choose the URL where your visitors will be redirected after they have clicked on the notification.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="send_to_url">{!! Helpers::translate('send-to-url', 'Send to URL') !!}</label>
                                  <input type="text" placeholder="{!! Helpers::translate('example-trustactivitycomsignup', 'Example: trustactivity.com/signup') !!}" id="send_to_url" name="send_to_url" value="{{ $module->send_to_url }}" data-value="{{ $module->send_to_url }}">
                              </div>
                              <div class="module_add_row customize_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden question_block_top2">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('open-link-in-new-window', 'Open link in new window') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('toggle-this-on-if-you-want-to-open-this-link-in-new-window', 'Toggle this On, if you want to open this link in new window.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/guide-step-2" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label>{!! Helpers::translate('open-link-in-new-window', 'Open link in new window') !!}</label>
                                  <div class="check_block">
                                    @if($module->open_new == 'off')
                                      <input type="radio" value="off" id="open_new_no" checked="checked" name="open_new" data-value="off">
                                      <label for="open_new_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                      <input type="radio" value="on" id="open_new_yes" name="open_new" data-value="off">
                                      <label for="open_new_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    @else 
                                      <input type="radio" value="off" id="open_new_no" name="open_new" data-value="on">
                                      <label for="open_new_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                      <input type="radio" value="on" id="open_new_yes" name="open_new" checked="checked" data-value="on">
                                      <label for="open_new_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    @endif
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
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8">
                    <div class="module_link">
                        <div class="module_link_back back_step"><a href="/admin/domains/<?=$module->domain_id;?>" class="link_back active" id="addModuleBackStep"><span></span><span>{!! Helpers::translate('back', 'Back') !!}</span></a></div>
                        <div class="module_link_next"><a href="" class="link_next" id="addModuleNextStep"><span>{!! Helpers::translate('next', 'Next') !!}</span><span></span></a></div>
                        <div class="module_link_next finish_step"><a href="" class="link_next" id="finishModuleStep"><span>{!! Helpers::translate('save', 'Save') !!}</span><span></span></a></div> 
                        <input type="hidden" name="domain" value="{{ $domain->url }}" />
                        <input type="hidden" name="domain_id" value="{{ $domain->id }}" />
                        <input type="hidden" name="module_id" value="{{ $module->id }}" />
                    </div>
                </div>
            </div>              
        </div>
    </div>
 
@endsection
