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
  <div class="sign_content">
      <div class="sign_title">
          <h1>Change your password</h1>
      </div>
      <div class="sign_form">
          <form method="POST" action="/auth/reset/save" class="sing_in_form">
            <input type="hidden" name="hash" value="{{ $token }}"> 
            {{ csrf_field() }}
              <div class="sign_form_row" <?php if(isset($err_arr['email'])){ echo 'style="margin-top: 25px;"'; } ?> >   
                  <input type="email" id="email" name="email" value="{{ old('email') }}" <?php if(isset($err_arr['email'])){ echo 'class="error"'; } ?> >
                  <label for="email">
                      <span class="sign_form_icon login_icon <?php if(isset($err_arr['email'])){ echo 'login_error'; } ?>"></span>
                      <span class="sign_form_placeholder">Email Address</span>
                  </label>
                  @if(isset($err_arr['email'])) 
                    <p class="error_text">{!! $err_arr['email'] !!}</p>
                  @endif
              </div>
              <div class="sign_form_row" <?php if(isset($err_arr['password'])){ echo 'style="margin-top: 25px;"'; } ?> >   
                  <input type="password" id="password" name="password" <?php if(isset($err_arr['password'])){ echo 'class="error"'; } ?> >   
                  <label for="password">
                      <span class="sign_form_icon pass_icon <?php if(isset($err_arr['password'])){ echo 'pass_error'; } ?>"></span>
                      <span class="sign_form_placeholder">Password</span>
                  </label>
                  @if(isset($err_arr['password'])) 
                    <p class="error_text">{!! $err_arr['password'] !!}</p>
                  @endif
              </div>
              <div class="sign_form_row">
                  <input type="password" id="password-confirm" name="password_confirmation">
                  <label for="password-confirm">
                      <span class="sign_form_icon pass_icon"></span>
                      <span class="sign_form_placeholder">Confirm Password</span>
                  </label>
              </div>
              <div class="sign_form_row sign_form_btn">
                  <button class="btn" type="submit">Change password</button>
              </div>
          </form>
      </div>
  </div>

@endsection
 
 