@extends('Panel::layouts/auth')

@section('content')

  <div class="sign_content" style="width: 100%; max-width: 600px; ">
      <div class="sign_title">
          <h1>We've emailed you a link to reset your password. Please follow the instructions to complete the password reset process.</h1>
      </div>
      <div class="truble_login">
          <p>Already have an account? <a href="/auth/login">Login here</a></p>
          <p>Don't have an account? <a href="/auth/register">Sign up here</a></p>
      </div>
  </div>

@endsection

 