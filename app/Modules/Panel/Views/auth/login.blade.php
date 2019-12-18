@extends('Panel::layouts/auth')

@section('content')

    @if(Session::has('changed'))
      <div class="sign_content singup_content">
    @else
        <div class="sign_content">
    @endif
    <div class="sign_title">
          <h1><?=(isset($translate['welcome-to-trust-activity']) ? $translate['welcome-to-trust-activity'] : 'Welcome to Trust Activity');?></h1>
    </div>
    @if(Session::has('changed'))
      <div class="sign_text" style="color: #21c491;">{{ Session::get('changed') }}</div>
    @endif
    <? $err_arr = [];

      foreach ($errors->all() as $key => $value) {

        $email      = strpos(strtolower($value), 'email');
        $password   = strpos(strtolower($value), 'password');

        if ($email      !== false) { $err_arr['email']      = $value; }
        if ($password   !== false) { $err_arr['password']   = $value; }
      } ?>
      <div class="sign_form">
          <form method="POST" action="/auth/login" class="sing_in_form">
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
                    <p class="error_text"><?=(isset($translate['wrong-emailpassword-combination']) ? $translate['wrong-emailpassword-combination'] : 'Wrong email/password combination.');?></p>
                  @endif
              </div>
              <div class="sign_form_row">
                  <input type="password" id="password" name="password" <?php if(Session::has('message')){ echo 'class="error"'; } ?> >
                  <label for="password">
                      <span class="sign_form_icon pass_icon <?php if(Session::has('message')){ echo 'pass_error'; } ?>"></span>
                      <span class="sign_form_placeholder"><?=(isset($translate['password']) ? $translate['password'] : 'Password');?></span>
                  </label>
              </div>
              <div class="sign_form_row sign_form_btn">
                  <button class="btn" type="submit"><?=(isset($translate['sign-in']) ? $translate['sign-in'] : 'Sign in');?></button>
              </div>
              <div class="sign_form_row social">
                <div class="line">
                  <span>or continue with</span>                  
                </div>
                <a href="/auth/facebook" rel="nofollow" class="auth-btn-facebook"><i></i>Facebook</a>
                <!--<a href="/auth/twitter" rel="nofollow" class="auth-btn-twitter"><i></i>Twitter</a>-->
                <a href="/auth/google" rel="nofollow" class="auth-btn-google"><i></i>Google</a>
              </div>
          </form>
          <div class="truble_login">
              <p><?=(isset($translate['trouble-signing-in']) ? $translate['trouble-signing-in'] : 'Trouble signing in?');?>
                <a href="/auth/reset">
                  <?=(isset($translate['reset-your-password']) ? $translate['reset-your-password'] : 'Reset your password');?>
                    
                  </a>
              </p>
              <p>
                <?=(isset($translate['dont-have-an-account']) ? $translate['dont-have-an-account'] : 'Don\'t have an account?');?>
                <a href="/auth/register"><?=(isset($translate['sign-up-here']) ? $translate['sign-up-here'] : 'Sign up here');?></a>
              </p>
          </div>
      </div>
  </div>

<script type="text/javascript">
 
 if (localStorage.getItem("trialEmail") !== null) {
    var trial_email = localStorage.getItem('trialEmail');  
    localStorage.removeItem('trialEmail'); 
    var input = document.getElementById('email').value;
    if (input == '') {
      document.getElementById('email').value = trial_email;
    }
  }
  console.log(email);

</script>








 
@endsection

 