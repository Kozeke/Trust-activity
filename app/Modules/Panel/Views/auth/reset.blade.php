@extends('Panel::layouts/auth')

@section('content')
<? $err_arr = [];

  foreach ($errors->all() as $key => $value) {

    $email      = strpos(strtolower($value), 'email');
    $password   = strpos(strtolower($value), 'password');
    $bonus_code = strpos(strtolower($value), 'bonus code');

    if ($email      !== false) { $err_arr['email']      = $value; }
    if ($password   !== false) { $err_arr['password']   = $value; }
    if ($bonus_code !== false) { $err_arr['bonus_code'] = $value; }
  } ?>
  <div class="sign_content singup_content">
      <div class="sign_title">
          <h1><?=(isset($translate['password-reset']) ? $translate['password-reset'] : 'Password reset');?></h1>
      </div>
      <div class="sign_text">
        <?=(isset($translate['enter-your-email-address-below-and-well-send-you-a-link-to-reset-your-password']) ? $translate['enter-your-email-address-below-and-well-send-you-a-link-to-reset-your-password'] : 'Enter your email address below and we\'ll send you a link to reset your password.');?></h1>
      </div>
      <div class="sign_form">
          <form method="POST" action="/auth/reset" class="sing_in_form">
            {{ csrf_field() }}
              @if(Session::has('message'))
                <div class="sign_form_row" style="margin-top: 25px;">
              @else 
                <div class="sign_form_row">
              @endif
                  <input type="email" id="email" name="email" value="{{ old('email') }}" <?php if(Session::has('message')){ echo 'class="error"'; } ?> >
                  <label for="email">
                      <span class="sign_form_icon login_icon <?php if(Session::has('message')){ echo 'login_error'; } ?>"></span>
                      <span class="sign_form_placeholder"><?=(isset($translate['email-address']) ? $translate['email-address'] : 'Email address');?></span>
                  </label>
                  @if(Session::has('message'))
                    <p class="error_text">{{ Session::get('message') }}</p>
                  @endif
              </div>
              <div class="sign_form_row sign_form_btn">
                  <button class="btn" type="submit">Reset</button>
              </div>
          </form>
          <div class="truble_login">
              <p><?=(isset($translate['already-have-an-account']) ? $translate['already-have-an-account'] : 'Already have an account?');?>
                <a href="/auth/login"><?=(isset($translate['login-here']) ? $translate['login-here'] : 'Login here');?></a>
              </p>
              <p> 
                <?=(isset($translate['dont-have-an-account']) ? $translate['dont-have-an-account'] : 'Don\'t have an account?');?>
                <a href="/auth/register"><?=(isset($translate['sign-up-here']) ? $translate['sign-up-here'] : 'Sign up here');?></a>
              </p>
          </div>
      </div>
  </div>
 
@endsection

 