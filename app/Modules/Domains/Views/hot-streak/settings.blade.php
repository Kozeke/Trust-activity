@extends('Panel::layouts/app')

@section('title', 'Domain - settings')
@section('description', 'Domain - settings')

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>{!! Helpers::translate('notification-settings', 'Notification settings') !!}</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/domains" class="breadcrumbs_link">{!! Helpers::translate('all-domains', 'All Domains') !!}</a></li>
            <li class="breadcrumbs_item"><a href="/admin/domains/{{ $domain->id }}" class="breadcrumbs_link">{{ $domain->url }}</a></li>
            <li class="breadcrumbs_item active">{!! Helpers::translate('notification-settings', 'Notification settings') !!}</li>
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
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden question_block_top2">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('viewing-this-page', 'Viewing this page') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('shows-how-many-visitors-are-currently-looking-at-this-page', 'Shows how many visitors are currently looking at this page.') !!}</p>
                                              <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <!--<a href="" class="question_block_false">Still confused</a>-->
                                          </div>
                                      </div>
                                  </div>
                                  <label>{!! Helpers::translate('viewing-this-page-notification', '"Viewing this page" - notification') !!}</label>
                                  <div class="check_block">
                                    @if($settings->viewing_this_page == 'off') 
                                      <input type="radio" id="viewing_this_page_no" name="viewing_this_page" value="off" checked="checked">
                                      <label for="viewing_this_page_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                      <input type="radio" id="viewing_this_page_yes" name="viewing_this_page" value="on">
                                      <label for="viewing_this_page_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    @else
                                      <input type="radio" id="viewing_this_page_no" name="viewing_this_page" value="off">
                                      <label for="viewing_this_page_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                      <input type="radio" id="viewing_this_page_yes" name="viewing_this_page" value="on" checked="checked">
                                      <label for="hide_notifications_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    @endif
                  									<span class="toggle-outside">
                  										<span class="toggle-inside"></span>
                  									</span>
                                  </div>
                              </div>
                              <div class="module_add_row">
                                  <div class="question">
                                      <div class="question_icon"></div> 
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden question_block_top2">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('hide-notifications-on-mobile', 'Hide notifications on mobile') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('toggle-this-option-on-if-you-dont-want-to-show-any-notifications-on-mobile-devices', 'Toggle this option On if you don’t want to show any notifications on mobile devices.') !!}</p>
                                              <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <!--<a href="#" class="question_block_false">Still confused</a>-->
                                          </div>
                                      </div> 
                                  </div>
                                  <label>{!! Helpers::translate('hide-notifications-on-mobile', 'Hide notifications on mobile') !!}</label>
                                  <div class="check_block">
                                    @if($settings->hide_notifications == 'no')
                                      <input type="radio" id="hide_notifications_no" name="hide_notifications" value="no" checked="checked">
                                      <label for="hide_notifications_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                      <input type="radio" id="hide_notifications_yes" name="hide_notifications" value="yes">
                                      <label for="hide_notifications_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    @else 
                                      <input type="radio" id="hide_notifications_no" name="hide_notifications" value="no">
                                      <label for="hide_notifications_no" class="check_label">{!! Helpers::translate('no', 'No') !!}</label>
                                      <input type="radio" id="hide_notifications_yes" name="hide_notifications" value="yes" checked="checked">
                                      <label for="hide_notifications_yes" class="check_label">{!! Helpers::translate('yes', 'Yes') !!}</label>
                                    @endif
                                      <span class="toggle-outside">
                                              <span class="toggle-inside"></span>
                                          </span>
                                  </div>
                              </div>
                              <div class="module_add_row customize_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden question_block_top2">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('show-on-top-of-page-on-mobile', 'Show on top of page on mobile') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('choose-position-for-notifications-on-mobile-devices-top-or-bottom', 'Choose position for notifications on mobile devices. Top or Bottom?') !!}</p>
                                              <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <!--<a href="" class="question_block_false">Still confused</a>-->
                                          </div>
                                      </div>
                                  </div>
                                  <label>{!! Helpers::translate('show-on-top-of-page-on-mobile', 'Show on top of page on mobile') !!}</label>
                                  <div class="check_block">
                                    @if($settings->show_on_top == 'no')
                                      <input type="radio" id="show_on_top_no" name="show_on_top" checked="checked" value="no">
                                      <label for="show_on_top_no" class="check_label">{!! Helpers::translate('off', 'Off') !!}</label>
                                      <input type="radio" id="show_on_top_yes" name="show_on_top" value="yes">
                                      <label for="show_on_top_yes" class="check_label">{!! Helpers::translate('on', 'On') !!}</label>
                                    @else
                                      <input type="radio" id="show_on_top_no" name="show_on_top" value="no">
                                      <label for="show_on_top_no" class="check_label">{!! Helpers::translate('off', 'Off') !!}</label>
                                      <input type="radio" id="show_on_top_yes" name="show_on_top" checked="checked" value="yes">
                                      <label for="show_on_top_yes" class="check_label">{!! Helpers::translate('on', 'On') !!}</label>
                                    @endif
                                      <span class="toggle-outside">
                                              <span class="toggle-inside"></span>
                                          </span>
                                  </div>
                              </div>
                              <div class="module_add_row customize_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div> 
                                      <div class="question_block_hidden question_block_top2">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('position-notifications', 'Position notifications') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('choose-position-for-notifications-on-desktop-laptops-and-tablet-devices-left-or-right', 'Choose position for notifications on Desktop, Laptops and Tablet devices. Left or Right?') !!}</p>
                                              <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <!--<a href="" class="question_block_false">Still confused</a>-->
                                          </div>
                                      </div>
                                  </div>
                                  <label>{!! Helpers::translate('position-notifications', 'Position notifications') !!}</label>
                                  <div class="check_block">
                                    @if($settings->position == 'off')
                                      <input type="radio" id="position_left" name="position" value="off" checked="checked">
                                      <label for="position_left" class="check_label" checked="checked">{!! Helpers::translate('left', 'Left') !!}</label>
                                      <input type="radio" id="position_right" name="position" value="on">
                                      <label for="position_right" class="check_label">{!! Helpers::translate('right', 'Right') !!}</label>
                                    @else
                                      <input type="radio" id="position_left" name="position" value="off">
                                      <label for="position_left" class="check_label" checked="checked">{!! Helpers::translate('left', 'Left') !!}</label>
                                      <input type="radio" id="position_right" name="position" value="on" checked="checked"> 
                                      <label for="position_right" class="check_label">{!! Helpers::translate('right', 'Right') !!}</label>
                                    @endif
                                      <span class="toggle-outside">
                                          <span class="toggle-inside"></span>
                                      </span>
                                  </div>
                              </div>
                              <div class="module_add_row customize_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block"> 
                                              <p class="question_block_name">{!! Helpers::translate('set-the-spacing-between-notifications-in', 'Set the Spacing Between Notifications in') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('setting-the-interval-with-which-notifications-will-be-displayed', 'Setting the interval with which notifications will be displayed.') !!}</p>
                                              <a href="#" class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <!--<a href="" class="question_block_false">Still confused</a>-->
                                          </div>
                                      </div>
                                  </div>
                                  <label for="spacing_between">
                                      <span>{!! Helpers::translate('set-the-spacing-between-notifications-in', 'Set the Spacing Between Notifications in') !!}</span><input type="number" name="spacing_between" id="spacing_between" placeholder="30" value="{{ $settings->spacing_between }}" class="input_small"><span>{!! Helpers::translate('seconds', 'seconds') !!}.</span>
                                  </label>
                              </div>
                              <div class="module_add_row customize_row">
                                  <div class="question">
                                      <div class="question_icon"></div>
                                      <div class="question_fon"></div>
                                      <div class="question_block_hidden">
                                          <div class="c-question_block">
                                              <p class="question_block_name">{!! Helpers::translate('locale', 'Locale') !!}</p>
                                              <p class="question_block_text">{!! Helpers::translate('this-option-is-designed-to-correctly-translate-time-information', 'This option is designed to correctly translate time information.') !!}</p>
                                              <a class="question_block_ok">{!! Helpers::translate('got-it', 'Got It!') !!}</a>
                                              <a href="/admin/faq/setup-and-adjustments/how-to-launch-your-first-proof-notifications" target="_blank" class="question_block_false">{!! Helpers::translate('still-confused', 'Still confused') !!}</a>
                                          </div>
                                      </div>
                                  </div>
                                  <label for="locale">{!! Helpers::translate('locale', 'Locale') !!}</label>
                                  <div class="module_add_row_input">
                                    <select name="locale" id="locale">
                                      <option value="en" <?php if($settings->locale == 'en')  echo 'selected'; ?> >{!! Helpers::translate('english', 'English') !!}</option>
                                      <option value="de" <?php if($settings->locale == 'de')  echo 'selected'; ?> >{!! Helpers::translate('german', 'German') !!}</option>                                      
                                      <option value="it" <?php if($settings->locale == 'it')  echo 'selected'; ?> >{!! Helpers::translate('italian', 'Italian') !!}</option>
                                      <option value="el" <?php if($settings->locale == 'el')  echo 'selected'; ?> >{!! Helpers::translate('greek', 'Greek') !!}</option>
                                      <option value="ru" <?php if($settings->locale == 'ru')  echo 'selected'; ?> >{!! Helpers::translate('russian', 'Russian') !!}</option>
                                    </select>
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
                        <div class="module_link_next" style="float: right;">
                          <a href="" class="link_next" id="updateSettings">
                            <span>{!! Helpers::translate('finish', 'Finish') !!}</span><span></span>
                          </a>
                        </div>                   
                        <input type="hidden" name="domain" value="{{ $domain->url }}" />
                        <input type="hidden" name="domain_id" value="{{ $domain->id }}" />
                    </div>
                </div>
            </div>              
        </div>
    </div>
 
@endsection
