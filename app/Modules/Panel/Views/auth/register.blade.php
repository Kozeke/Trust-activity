@extends('Panel::layouts/auth')

@section('content')

  <div class="sign_content singup_content">
      <div class="sign_title">
          <h1><?=(isset($translate['sign-up']) ? $translate['sign-up'] : 'Sign Up');?></h1>
      </div>
      <div class="sign_text"><?=(isset($translate['enter-your-work-email-to-access-your-fully-loaded-7-day-trial']) ? $translate['enter-your-work-email-to-access-your-fully-loaded-7-day-trial'] : 'Enter your work email to access your fully-loaded 7-day trial.');?></div>
      <div class="sign_form">
        <? $err_arr = [];
 
          foreach ($errors->all() as $key => $value) {

            $email      = strpos(strtolower($value), 'email');
            $password   = strpos(strtolower($value), 'password');
            $bonus_code = strpos(strtolower($value), 'bonus code');

            if ($email      !== false) { $err_arr['email']      = $value; }
            if ($password   !== false) { $err_arr['password']   = $value; }
            if ($bonus_code !== false) { $err_arr['bonus_code'] = $value; }
          } ?>
          <form method="POST" action="/auth/register" class="sing_in_form"> 
            {{ csrf_field() }}
              <div class="sign_form_row" <?php if(isset($err_arr['email'])){ echo 'style="margin-top: 25px;"'; } ?> >   
                  <input type="email" id="email" name="email" value="{{ old('email') }}" <?php if(isset($err_arr['email'])){ echo 'class="error"'; } ?> >
                  <label for="email">
                      <span class="sign_form_icon login_icon <?php if(isset($err_arr['email'])){ echo 'login_error'; } ?>"></span>
                      <span class="sign_form_placeholder"><?=(isset($translate['email-address']) ? $translate['email-address'] : 'Email address');?></span>
                  </label>
                  @if(isset($err_arr['email'])) 
                    <p class="error_text">{!! $err_arr['email'] !!}</p>
                  @endif
              </div>
              <div class="sign_form_row" <?php if(isset($err_arr['password'])){ echo 'style="margin-top: 25px;"'; } ?> >   
                  <input type="password" id="password" name="password" <?php if(isset($err_arr['password'])){ echo 'class="error"'; } ?> >   
                  <label for="password">
                      <span class="sign_form_icon pass_icon <?php if(isset($err_arr['password'])){ echo 'pass_error'; } ?>"></span>
                      <span class="sign_form_placeholder"><?=(isset($translate['password']) ? $translate['password'] : 'Password');?></span>
                  </label>
                  @if(isset($err_arr['password'])) 
                    <p class="error_text">{!! $err_arr['password'] !!}</p>
                  @endif
              </div>
              <div class="sign_form_row">
                  <input type="password" id="password-confirm" name="password_confirmation">
                  <label for="password-confirm">
                      <span class="sign_form_icon pass_icon"></span>
                      <span class="sign_form_placeholder"><?=(isset($translate['confirm-password']) ? $translate['confirm-password'] : 'Confirm Password');?></span>
                  </label>
              </div> 
              <div class="sign_form_row bonus_row">
                  <div class="row_code_text"><?=(isset($translate['do-you-have-a-bonus-code']) ? $translate['do-you-have-a-bonus-code'] : 'Do you have a bonus code?');?></div>
                  <div class="bonus_row_toggle">
                      <input type="checkbox" id="bonus_code" name="bonus_open" <?php if(null !== old('bonus_open')){ echo 'checked="checked"'; } ?>>
                      <label for="bonus_code">
                          <span class="bonus_code_yes"><?=(isset($translate['yes']) ? $translate['yes'] : 'Yes');?></span>
                          <span class="bonus_code_no"><?=(isset($translate['no']) ? $translate['no'] : 'No');?></span>
                      </label>
                  </div>
              </div>
              @if(null !== old('bonus_open') && isset($err_arr['bonus_code']))
                <div class="sign_form_row bonus_row_input" style="display: block; margin-top: 25px;">
              @elseif(null !== old('bonus_open'))
                <div class="sign_form_row bonus_row_input" style="display: block;">
              @else 
                <div class="sign_form_row bonus_row_input">
              @endif
                <input type="text" id="bonus-code" name="bonus_code" value="{!! old('bonus_code') !!}" <?php if(isset($err_arr['bonus_code'])){ echo 'class="error"'; } ?> >  
                <label for="sing_bonus">
                    <span class="sign_form_icon bonus_icon <?php if(isset($err_arr['bonus_code'])){ echo 'bonus_error'; } ?>"></span>
                    <span class="sign_form_placeholder"><?=(isset($translate['bonus-code']) ? $translate['bonus-code'] : 'Bonus Code');?></span>
                </label> 
                @if(isset($err_arr['bonus_code'])) 
                    <p class="error_text">{!! $err_arr['bonus_code'] !!}</p>
                @endif
              </div>
              <div class="sign_form_row sing_agree">
                  <input type="checkbox" name="agrement" id="sing_agree" class="checked_agree" checked="checked">
                  <label for="sing_agree"><?=(isset($translate['i-accept']) ? $translate['i-accept'] : 'I accept');?> <a href="/privacy" target="_blank"><?=(isset($translate['privacy-policy']) ? $translate['privacy-policy'] : 'Privacy Policy');?></a></label>
              </div>
              <div class="sign_form_row sign_form_btn">
                <?php if(isset($_GET['referral_id'])): ?>  
                  <input type="hidden" name="refferal_id" value="{{ $_GET['referral_id'] }}">
                <?php endif; ?>
                  <button class="btn" type="submit"><?=(isset($translate['create-account']) ? $translate['create-account'] : 'Create Account');?></button>
              </div>
          </form>
          <div class="truble_login">
              <p><?=(isset($translate['already-have-an-account']) ? $translate['already-have-an-account'] : 'Already have an account?');?>
                <a href="/auth/login"><?=(isset($translate['login-here']) ? $translate['login-here'] : 'Login here');?></a>
              </p>
          </div>
      </div>
  </div>
 
@endsection

 